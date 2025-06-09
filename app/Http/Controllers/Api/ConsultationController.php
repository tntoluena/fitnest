<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    /**
     * Memberikan informasi yang dibutuhkan untuk memulai chat WhatsApp.
     */
    public function getInfo(): JsonResponse
    {
        $user = Auth::user();

        $trainerName = config('consultation.trainer_name');
        $waNumber = config('consultation.whatsapp_number');
        $messageTemplate = config('consultation.message_template');

        $finalMessage = str_replace(
            ['{trainer_name}', '{user_name}'],
            [$trainerName, $user->name],
            $messageTemplate
        );

        return response()->json([
            'trainer_name' => $trainerName,
            'whatsapp_number' => $waNumber,
            'prefilled_message' => $finalMessage,
        ]);
    }
}