<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class VerificationController extends Controller
{
    public function sendOTP(Request $request)
    {
        // Valider le numéro de téléphone
        $request->validate([
            'phone' => 'required|string',
        ]);

        // Générer un code OTP aléatoire
        $otp = rand(100000, 999999);

        // Envoyer le code OTP via Twilio
        try {
            $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

            $twilio->messages->create(
                $request->phone, // Numéro de téléphone du destinataire
                [
                    'from' => env('TWILIO_PHONE_NUMBER'),
                    'body' => "Votre code de validation est: $otp",
                ]
            );

            // Retourner une réponse JSON avec le code OTP (pour le débogage)
            return response()->json([
                'message' => 'Code OTP envoyé avec succès',
                'otp' => $otp, // À ne pas faire en production !
            ]);
        } catch (\Exception $e) {
            // Journaliser l'erreur
            Log::error('Erreur lors de l\'envoi du code OTP : ' . $e->getMessage());

            // Retourner une réponse d'erreur
            return response()->json([
                'message' => 'Échec de l\'envoi du code OTP',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}