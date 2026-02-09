<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Str;

class StaffUsersSeeder extends Seeder
{
    public function run()
    {
        // Récupérer le rôle staff
        $staffRole = Role::where('name', 'staff')->first();

        // Si le rôle staff n'existe pas, le créer
        if (!$staffRole) {
            $staffRole = Role::create([
                'name' => 'staff',
                'display_name' => 'Staff',
                'description' => 'Rôle de membre du staff',
                'grade' => 3
            ]);
        }

        // Créer 10 utilisateurs staff
        for ($i = 0; $i < 10; $i++) {
            // Générer des dates aléatoires pour simuler l'activité
            $registeredAt = Carbon::now()->subMonths(rand(1, 6));
            $lastLoginAt = Carbon::now()->subHours(rand(0, 72));
            $lastActivityAt = $lastLoginAt->copy()->addMinutes(rand(0, 180));
            $isOnline = $lastActivityAt->gt(Carbon::now()->subMinutes(15));

            // Vérifier si l'utilisateur existe déjà
            $matricule = 'STF' . str_pad($i + 1, 4, '0', STR_PAD_LEFT);
            $email = 'staff' . ($i + 1) . '@ztf.com';
            
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                'matricule' => $matricule,
                'password' => bcrypt('password'),
                // Assignation aléatoire à un département et service existants
                'department_id' => Department::inRandomOrder()->first()->id ?? null,
                'service_id' => Service::inRandomOrder()->first()->id ?? null,
                'created_at' => $registeredAt,
                'registered_at' => $registeredAt,
                'info_updated_at' => $registeredAt->copy()->addDays(rand(1, 30)),
                'last_login_at' => $lastLoginAt,
                'last_activity_at' => $lastActivityAt,
                'is_online' => $isOnline,
                'last_seen_at' => $lastActivityAt,
                'last_login_ip' => fake()->ipv4(),
                'remember_token' => Str::random(10)
            ]);

            // Attacher le rôle staff s'il ne l'a pas déjà
            if (!$user->hasRole('staff')) {
                $user->roles()->attach($staffRole->id);
            }
        }
    }
}
