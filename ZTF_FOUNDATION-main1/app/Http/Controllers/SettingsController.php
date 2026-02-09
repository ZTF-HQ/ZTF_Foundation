<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Constructeur
     */
    public function __construct()
    {
        // Les middlewares sont gérés dans les routes
    }

    /**
     * Met à jour les paramètres du site
     */
    public function updateSiteSettings(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:1000',
            'contact_email' => 'required|email',
        ]);

        try {
            // Mettre à jour les paramètres dans la base de données
            Setting::set('site_name', $validated['site_name']);
            Setting::set('site_description', $validated['site_description']);
            Setting::set('contact_email', $validated['contact_email']);

            // Mettre à jour le fichier .env
            $this->updateEnvFile([
                'APP_NAME' => $validated['site_name'],
                'MAIL_FROM_ADDRESS' => $validated['contact_email']
            ]);

            // Vider le cache des configurations
            Artisan::call('config:clear');

            return back()->with('success', 'Les paramètres du site ont été mis à jour avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour des paramètres : ' . $e->getMessage());
        }
    }

    /**
     * Met à jour les paramètres de sécurité
     */
    public function updateSecuritySettings(Request $request)
    {
        $validated = $request->validate([
            'two_factor_auth' => 'boolean',
            'force_password_change' => 'boolean',
            'session_lifetime' => 'required|integer|min:1',
        ]);

        try {
            Setting::set('two_factor_auth', $validated['two_factor_auth'], 'security');
            Setting::set('force_password_change', $validated['force_password_change'], 'security');
            Setting::set('session_lifetime', $validated['session_lifetime'], 'security');

            // Mettre à jour le fichier de configuration de session
            config(['session.lifetime' => $validated['session_lifetime']]);
            
            $this->updateEnvFile([
                'SESSION_LIFETIME' => $validated['session_lifetime']
            ]);

            return back()->with('success', 'Les paramètres de sécurité ont été mis à jour avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour des paramètres de sécurité : ' . $e->getMessage());
        }
    }

    /**
     * Met à jour les paramètres de notification
     */
    public function updateNotificationSettings(Request $request)
    {
        $validated = $request->validate([
            'email_notifications' => 'boolean',
            'activity_notifications' => 'boolean',
            'security_notifications' => 'boolean',
        ]);

        try {
            foreach ($validated as $key => $value) {
                Setting::set($key, $value, 'notifications');
            }

            return back()->with('success', 'Les préférences de notification ont été mises à jour avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour des préférences : ' . $e->getMessage());
        }
    }

    /**
     * Crée une sauvegarde de la base de données
     */
    public function createBackup()
    {
        try {
            // Créer un nom unique pour la sauvegarde
            $filename = 'backup-' . date('Y-m-d-His') . '.sql';
            
            // Configurer les variables d'environnement pour pg_dump
            putenv("PGPASSWORD=" . config('database.connections.pgsql.password'));
            
            // Exécuter la commande de backup
            $command = sprintf(
                'pg_dump -h %s -p %s -U %s -F p %s > %s',
                config('database.connections.pgsql.host'),
                config('database.connections.pgsql.port'),
                config('database.connections.pgsql.username'),
                config('database.connections.pgsql.database'),
                storage_path('app/backups/' . $filename)
            );

            $result = exec($command, $output, $returnCode);
            
            // Nettoyer la variable d'environnement
            putenv("PGPASSWORD");
            
            if ($returnCode !== 0) {
                throw new \Exception("Erreur lors de l'exécution de pg_dump. Code: " . $returnCode);
            }

            // Enregistrer les informations de la sauvegarde
            Setting::create([
                'key' => 'last_backup',
                'value' => $filename,
                'group' => 'backup'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sauvegarde créée avec succès',
                'filename' => $filename
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la sauvegarde : ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Nettoie le cache de l'application
     */
    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');

            return response()->json([
                'success' => true,
                'message' => 'Le cache a été nettoyé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du nettoyage du cache : ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Active ou désactive le mode maintenance
     */
    public function toggleMaintenance(Request $request)
    {
        try {
            if ($request->input('enable')) {
                Artisan::call('down', [
                    '--message' => "Le site est en maintenance. Nous serons bientôt de retour.",
                    '--retry' => 60
                ]);
                
                Setting::set('maintenance_mode', true, 'system');
                $message = 'Mode maintenance activé';
            } else {
                Artisan::call('up');
                Setting::set('maintenance_mode', false, 'system');
                $message = 'Mode maintenance désactivé';
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du changement du mode maintenance : ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Met à jour le fichier .env
     */
    private function updateEnvFile(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                $str .= "\n"; // Au cas où la variable recherchée n'est pas trouvée
                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                // Si la clé existe, on la remplace
                if (is_bool($envValue)) {
                    $envValue = $envValue ? 'true' : 'false';
                }

                $envValue = is_string($envValue) ? '"'.$envValue.'"' : $envValue;
                
                if ($keyPosition !== false && $endOfLinePosition !== false) {
                    $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                } else {
                    $str .= "{$envKey}={$envValue}\n";
                }
            }
        }

        $str = substr($str, 0, -1);
        if (!file_put_contents($envFile, $str)) {
            throw new \Exception("Impossible de modifier le fichier .env");
        }

        return true;
    }

    /**
     * Récupère la liste des sauvegardes
     */
    public function getBackups()
    {
        $backups = collect(Storage::files('backups'))
            ->map(function($file) {
                return [
                    'name' => basename($file),
                    'size' => Storage::size($file),
                    'date' => Storage::lastModified($file),
                ];
            })
            ->sortByDesc('date');

        return response()->json($backups);
    }
}
