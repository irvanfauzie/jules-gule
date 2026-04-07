<?php

namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\ChunkModel;
use Smalot\PdfParser\Parser;

class Upload extends BaseController
{
    public function index()
    {
        return view('upload');
    }

    public function process()
    {
        $validationRule = [
            'document' => [
                'label' => 'File PDF',
                'rules' => 'uploaded[document]|ext_in[document,pdf]|max_size[document,20480]',
            ],
            'title' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $file = $this->request->getFile('document');

        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);

            $title = $this->request->getPost('title');
            $category = $this->request->getPost('category');
            $year = $this->request->getPost('year');

            $docModel = new DocumentModel();
            $docId = $docModel->insert([
                'title' => $title,
                'filename' => $newName,
                'category' => $category,
                'year' => $year
            ]);

            // PDF Text Extraction
            $parser = new Parser();
            $pdf = $parser->parseFile(WRITEPATH . 'uploads/' . $newName);
            $text = $pdf->getText();

            // Chunking
            $chunks = $this->chunkText($text, 1000); // 1000 characters per chunk

            $chunkModel = new ChunkModel();
            foreach ($chunks as $chunkContent) {
                if (trim($chunkContent) !== '') {
                    $chunkModel->insert([
                        'document_id' => $docId,
                        'chunk_content' => $chunkContent,
                        'metadata' => "Page context from $title"
                    ]);
                }
            }

            return redirect()->to('/bank-data')->with('success', 'Dokumen berhasil diunggah dan diproses.');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah dokumen.');
    }

    public function delete($id)
    {
        $docModel = new DocumentModel();
        $doc = $docModel->find($id);

        if ($doc) {
            // Delete file
            $filePath = WRITEPATH . 'uploads/' . $doc['filename'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Chunks will be deleted by ON DELETE CASCADE in DB
            $docModel->delete($id);

            return redirect()->to('/bank-data')->with('success', 'Dokumen berhasil dihapus.');
        }

        return redirect()->to('/bank-data')->with('error', 'Dokumen tidak ditemukan.');
    }

    private function chunkText($text, $size)
    {
        $chunks = [];
        $words = explode(' ', $text);
        $currentChunk = "";

        foreach ($words as $word) {
            if (strlen($currentChunk) + strlen($word) < $size) {
                $currentChunk .= $word . " ";
            } else {
                $chunks[] = trim($currentChunk);
                $currentChunk = $word . " ";
            }
        }
        if (!empty($currentChunk)) {
            $chunks[] = trim($currentChunk);
        }

        return $chunks;
    }
}
