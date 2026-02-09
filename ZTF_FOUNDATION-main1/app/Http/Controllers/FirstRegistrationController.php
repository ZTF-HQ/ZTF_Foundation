<?php

namespace App\Http\Controllers;

use App\Models\FirstRegistrationUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;


class FirstRegistrationController extends Controller
{
    /**
     * Affiche le formulaire d'inscription
     */
    public function showRegistrationForm()
    {
        return view('identification.form');
    }

    /**
     * Handle the first registration
     */
    public function register(Request $request)
    {
        \Log::info('Register method called');
        \Log::info('Request data:', $request->all());
        
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'first_email' => 'required|string|email|max:255',
            'first_password' => 'required|string|min:8',
        ]);

        // Create the user
        $user = FirstRegistrationUser::create([
            'first_name' => $validatedData['first_name'],
            'first_email' => $validatedData['first_email'],
            'first_password' => bcrypt($validatedData['first_password']),
        ]);

        // Generate unique identification code (8 digits)
        $identificationCode = str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
        
        // Store the code in cache with 2 minutes expiration
        Cache::put('identification_code_' . $user->id, $identificationCode, now()->addMinutes(2));

        // Send email with identification code
        Mail::raw("Votre code d'identification est : {$identificationCode}\nCe code expirera dans 2 minutes.", function($message) use ($user) {
            $message->to($user->first_email)
                   ->subject('Votre Code d\'Identification ZTF Foundation');
        });

        // Store user_id in session and redirect to identification page
        session(['user_id' => $user->id]);
        \Log::info('Session set with user_id: ' . $user->id);
        
        \Log::info('Redirecting to identification page');
        return redirect('/identification/identification-after-registration')
            ->with('success', 'Inscription réussie ! Veuillez vérifier votre email pour le code de vérification.');
    }

    /**
     * Show the identification form
     */
    public function showIdentification()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('identification.form')
                ->with('error', 'Veuillez vous inscrire d\'abord.');
        }

        return view('identification.identification_after_registration');
    }

    /**
     * Verify the identification code
     */
    public function verifyIdentification(Request $request)
    {
        return redirect()->route('BigForm');
    }

    /**
     * Resend the identification code
     */
    public function resendCode()
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->route('register')
                ->with('error', 'Session expirée. Veuillez recommencer l\'inscription.');
        }

        $user = FirstRegistrationUser::find($userId);
        
        if (!$user || !$user->first_email) {
            return back()->with('error', 'Impossible de trouver votre adresse email. Veuillez réessayer l\'inscription.');
        }

        try {
            // Generate new code
            $newCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Update the code in cache
            Cache::put('identification_code_' . $userId, $newCode, now()->addMinutes(2));

            // Send new email
            Mail::raw(
                "Votre nouveau code d'identification est : {$newCode}\n\n" .
                "Ce code expirera dans 2 minutes.\n\n" .
                "Si vous n'avez pas demandé ce code, veuillez ignorer cet email.",
                function($message) use ($user) {
                    $message->to($user->first_email)
                           ->subject('Nouveau Code d\'Identification - ZTF Foundation');
                }
            );

            return back()->with('success', 'Un nouveau code a été envoyé à votre adresse email ' . substr($user->first_email, 0, 3) . '***' . strstr($user->first_email, '@'));
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'envoi du code : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de l\'envoi du code. Veuillez réessayer.');
        }
    }
}
