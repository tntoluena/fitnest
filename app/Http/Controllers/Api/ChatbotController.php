<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http; // <-- Fasad HTTP untuk "berbicara" dengan API lain

class ChatbotController extends Controller
{
    /**
     * Menerima pertanyaan, mengirimkannya ke Gemini, dan mengembalikan jawaban.
     */
    public function chat(Request $request): JsonResponse
    {
        // 1. Validasi pertanyaan dari pengguna
        $validated = $request->validate([
            'question' => 'required|string|max:1000'
        ]);
        $userQuestion = $validated['question'];

        // 2. Ambil API Key dari config yang sudah kita siapkan
        $apiKey = config('services.gemini.key');
        if (!$apiKey) {
            return response()->json(['error' => 'Gemini API Key belum diatur di server.'], 500);
        }

        // 3. Siapkan data & prompt untuk dikirim ke Google Gemini
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

        // 4. Kirim request ke API Gemini menggunakan HTTP Client Laravel
        $response = Http::post($apiUrl, $payload);

        // 5. Olah jawaban dari Gemini jika berhasil
        if ($response->successful()) {
            // 'data_get' adalah cara aman untuk mengambil data dari array/JSON yang kompleks.
            // Ini mencegah error jika struktur response dari Gemini tidak sesuai harapan.
            $reply = data_get($response->json(), 'candidates.0.content.parts.0.text');

            return response()->json([
                'reply' => $reply ?? "Maaf, saya tidak bisa memberikan jawaban saat ini. Coba lagi nanti."
            ]);
        }

        // Jika request ke Gemini gagal (misal: API key salah, server down)
        return response()->json([
            'error' => 'Terjadi masalah saat berkomunikasi dengan layanan AI.',
            'details' => $response->json() // Sertakan detail error dari Gemini untuk debugging
        ], $response->status());
    }
}