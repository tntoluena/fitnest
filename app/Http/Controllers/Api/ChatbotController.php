<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http; 

class ChatbotController extends Controller
{
    /**
     * Menerima pertanyaan, mengirimkannya ke Gemini, dan mengembalikan jawaban.
     */
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'question' => 'required|string|max:1000'
        ]);
        $userQuestion = $validated['question'];

        $apiKey = config('services.gemini.key');
        if (!$apiKey) {
            return response()->json(['error' => 'Gemini API Key belum diatur di server.'], 500);
        }

        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key={$apiKey}";

        $payload = [
            'system_instruction' => [
                'parts' => [
                    'text' => "Anda adalah FitBot, asisten AI yang ramah dan suportif untuk aplikasi Fitnest. Jawaban Anda harus singkat, memotivasi, dan fokus pada kebugaran, nutrisi, serta kesehatan. Panggil pengguna dengan sebutan 'Sobat Sehat'."
                ]
            ],
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [['text' => $userQuestion]]
                ]
            ]
        ];

        $response = Http::post($apiUrl, $payload);

        if ($response->successful()) {
            $reply = data_get($response->json(), 'candidates.0.content.parts.0.text');

            return response()->json([
                'reply' => $reply ?? "Maaf, saya tidak bisa memberikan jawaban saat ini. Coba lagi nanti."
            ]);
        }

        return response()->json([
            'error' => 'Terjadi masalah saat berkomunikasi dengan layanan AI.',
            'details' => $response->json() // Sertakan detail error dari Gemini untuk debugging
        ], $response->status());
    }
}