<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class VerificationController extends Controller
{
    public function sendOTP(Request $request)
    {
        $phone = $request->phone;
        $otp = rand(100000, 999999); // Générer un code OTP aléatoire

        // Envoyer le code OTP via Twilio
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilio = new Client($sid, $token);

        $twilio->messages->create(
            $phone,
            [
                'from' => env('TWILIO_PHONE_NUMBER'),
                'body' => "Votre code de validation est: $otp",
            ]
        );

        return response()->json([
            'verificationId' => $otp, // Vous pouvez utiliser un identifiant unique ici
        ]);
    }
}