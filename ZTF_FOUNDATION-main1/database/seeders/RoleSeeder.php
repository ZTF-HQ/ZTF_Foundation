<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'SPAD',
                'display_name' => 'Super Administrateur',
                'description' => 'Super Administrateur avec tous les droits',
                'grade' => 1
            ],
            [
                'name' => 'CD',
                'display_name' => 'Chef de Département',
                'description' => 'Chef de département',
                'grade' => 2
            ],
            [
                'name' => 'NEH',
                'display_name' => 'Membre du Comité',
                'description' => 'Membre du comité de Nehemie',
                'grade' => 1
            ],
            [
                'name' => 'F',
                'display_name' => 'Staff',
                'description' => 'Membre du staff',
                'grade' => 3
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}