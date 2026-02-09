<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class TwoFAController extends Controller
{
    //generer le code ,le sauvegarder en session de laravel puis l'envoyer par email

    public function sendCode(Request $request)
    {
        // Valider l'email de la requête
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;
        Session::put('auth_email', $email);

        // Pour le test, on génère un code fixe
        $code = '123456789012';

        // Stockage en session
        Session::put('2fa_code', [
            'code' => $code,
            'email' => $email,
            'expires_at' => now()->addMinutes(30)
        ]);

        // Pour le test, on retourne directement le code et le succès
        return response()->json([
            'success' => true,
            'message' => "Email validé avec succès",
            'testCode' => $code, // Pour le test uniquement
            'nextStep' => true
        ]);
    }

    //Permet de verifier la saisi de l'utilisateur
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:12'
        ]);

        $twoFaData = Session::get('2fa_code');

        // Vérification simplifiée pour le test
        if ($request->code === $twoFaData['code']) {
            // Authentification réussie
            Session::put('verified', true);
            Session::forget('2fa_code');

            return response()->json([
                'success' => true,
                'message' => 'Authentification réussie',
                'redirect' => route('dashboard'), // Assurez-vous que cette route existe
                'nextStep' => true
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Code incorrect. Pour le test, utilisez: ' . $twoFaData['code']
        ]);
    }
}
