<?php

namespace App\Controllers;

use App\Models\ChunkModel;
use App\Models\ChatModel;
use App\Libraries\GeminiService;

class Chat extends BaseController
{
    public function index()
    {
        session();
        $chatModel = new ChatModel();
        $data['history'] = $chatModel->where('session_id', session_id())->orderBy('created_at', 'ASC')->findAll();
        return view('chat', $data);
    }

    public function send()
    {
        session();
        $message = $this->request->getPost('message');
        if (empty($message)) {
            return $this->response->setJSON(['error' => 'Pesan tidak boleh kosong']);
        }

        $sessionId = session_id();
        $chatModel = new ChatModel();

        // 1. Save User Message
        $chatModel->insert([
            'session_id' => $sessionId,
            'sender' => 'user',
            'message' => $message
        ]);

        // 2. Retrieval (RAG)
        $chunkModel = new ChunkModel();
        $relevantChunks = $chunkModel->searchChunks($message, 3);

        $context = "";
        $references = [];
        foreach ($relevantChunks as $chunk) {
            $context .= $chunk['chunk_content'] . "\n\n";
            $references[] = $chunk['doc_title'];
        }
        $references = array_unique($references);

        // 3. Construct Prompt
        $systemPrompt = "Anda adalah asisten hukum ahli untuk aplikasi Gule (Gerbang Undang-undang Legal Elektronik).
        Tugas Anda adalah menjawab pertanyaan pengguna secara akurat hanya berdasarkan dokumen hukum yang ada di bank data berikut:

        CONTEXT:
        " . $context . "

        INSTRUKSI:
        - Jika jawaban tidak ditemukan di dokumen, katakan bahwa informasi tersebut tidak tersedia dalam basis data Gule.
        - Selalu sertakan Pasal atau nomor Undang-undang yang menjadi referensi jawaban Anda berdasarkan context.
        - Gunakan bahasa Indonesia yang formal namun mudah dipahami.

        PERTANYAAN PENGGUNA: " . $message;

        // 4. Call Gemini
        $gemini = new GeminiService();
        $botResponse = $gemini->generateResponse($systemPrompt);

        // 5. Save Bot Response
        $chatModel->insert([
            'session_id' => $sessionId,
            'sender' => 'bot',
            'message' => $botResponse,
            'references' => implode(', ', $references)
        ]);

        return $this->response->setJSON([
            'message' => $botResponse,
            'references' => $references
        ]);
    }
}
