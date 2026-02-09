<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer les rôles et les utilisateurs staff
        $this->call([
            RoleSeeder::class, // Ajouter les rôles en premier
            DepartmentSeeder::class,
            ServiceSeeder::class,
            StaffUsersSeeder::class
        ]);
    }

    private function createBasicData()
    {
        // Créer les départements de base s'ils n'existent pas
        $departments = [
            ['name' => 'Ressources Humaines', 'description' => 'Gestion des ressources humaines'],
            ['name' => 'Finance', 'description' => 'Gestion financière'],
            ['name' => 'Communication', 'description' => 'Communication et marketing'],
            ['name' => 'Technique', 'description' => 'Support technique']
        ];

        foreach ($departments as $dept) {
            \App\Models\Department::firstOrCreate(
                ['name' => $dept['name']],
                $dept
            );
        }

        // Associer les services aux départements
        $servicesData = [
            'Ressources Humaines' => [
                ['name' => 'Recrutement', 'description' => 'Service de recrutement'],
                ['name' => 'Formation', 'description' => 'Service de formation']
            ],
            'Finance' => [
                ['name' => 'Comptabilité', 'description' => 'Service comptable'],
                ['name' => 'Budget', 'description' => 'Service budget']
            ],
            'Communication' => [
                ['name' => 'Marketing', 'description' => 'Service marketing'],
                ['name' => 'Relations publiques', 'description' => 'Service RP']
            ],
            'Technique' => [
                ['name' => 'Support', 'description' => 'Service support'],
                ['name' => 'Développement', 'description' => 'Service développement']
            ]
        ];

        foreach ($servicesData as $deptName => $services) {
            $department = \App\Models\Department::where('name', $deptName)->first();
            if ($department) {
                foreach ($services as $service) {
                    \App\Models\Service::firstOrCreate(
                        ['name' => $service['name']],
                        array_merge($service, ['department_id' => $department->id])
                    );
                }
            }
        }
    }
        }
    
