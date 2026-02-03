<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = \App\Models\User::select('id', 'name', 'email', 'matricule')->limit(5)->get();

echo "=== Utilisateurs disponibles ===\n";
foreach($users as $user) {
    echo "ID: {$user->id}\n";
    echo "  Name: {$user->name}\n";
    echo "  Email: {$user->email}\n";
    echo "  Matricule: {$user->matricule}\n";
    echo "\n";
}

if($users->isEmpty()) {
    echo "Aucun utilisateur trouvé dans la base de données.\n";
    echo "\nVous devez créer un utilisateur d'abord.\n";
}
?>
