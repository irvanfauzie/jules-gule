<?php

namespace App\Libraries;

use Gemini;

class GeminiService
{
    protected $client;

    public function __construct()
    {
        $apiKey = getenv('GEMINI_API_KEY') ?: '';
        $this->client = Gemini::client($apiKey);
    }

    public function generateResponse(string $prompt)
    {
        try {
            $result = $this->client->geminiPro()->generateContent($prompt);
            return $result->text();
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
