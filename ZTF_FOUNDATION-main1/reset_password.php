<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Créer/Réinitialiser un utilisateur de test
$user = \App\Models\User::findOrFail(1);
$user->password = bcrypt('password123');
$user->name = 'Staff Test';
$user->save();

echo "✅ Utilisateur réinitialisé !\n";
echo "Email: {$user->email}\n";
echo "Password: password123\n";
echo "Matricule: {$user->matricule}\n";
?>
