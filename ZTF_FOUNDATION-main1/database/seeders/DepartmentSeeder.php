<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            [
                'name' => 'ECSD',
                'description' => 'Ecole de la Connaisance et du Service de Dieu'
            ],
            [
                'name' => 'UMPJ',
                'description' =>'Universite Mondial de la Priere et du Jeune'
            ],
            [
                'name' => 'WCS',
                'description' => 'World Conquest Science'
            ],
            [
                'name' => 'CPJCM',
                'description' => 'Centre de Priere et de Jeune pour la conquete du Monde'
            ]
        ];

        foreach ($departments as $deptData) {
            $department = Department::firstOrCreate(
                ['name' => $deptData['name']],
                $deptData
            );

            // Créer le chef de département avec le matricule CM-HQ-{NAME}-CD
            User::firstOrCreate(
                ['email' => 'chef.' . strtolower($department->name) . '@ztf.com'],
                [
                    'name' => 'Chef du departement de ' . $department->name,
                    'password' => bcrypt('password'),
                    'matricule' => 'CM-HQ-' . $department->name . '-CD',
                    'department_id' => $department->id
                ]
            );
        }
    }
}