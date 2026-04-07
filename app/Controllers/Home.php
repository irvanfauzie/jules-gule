<?php

namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\ChunkModel;
use App\Models\ChatModel;

class Home extends BaseController
{
    public function index(): string
    {
        $docModel = new DocumentModel();
        $chunkModel = new ChunkModel();
        $chatModel = new ChatModel();

        $data = [
            'title' => 'Dashboard',
            'totalDocs' => $docModel->countAllResults(),
            'totalChunks' => $chunkModel->countAllResults(),
            'totalChats' => $chatModel->countAllResults(),
        ];

        return view('dashboard', $data);
    }

    public function bankData()
    {
        $docModel = new DocumentModel();
        $data = [
            'title' => 'Bank Data',
            'documents' => $docModel->orderBy('created_at', 'DESC')->findAll()
        ];
        return view('bank_data', $data);
    }
}
