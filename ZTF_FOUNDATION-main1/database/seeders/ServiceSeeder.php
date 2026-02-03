<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Department;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        // Tableau des services par département
        $servicesByDepartment = [
            'ECSD' => [
                [
                    'name' => 'FCD',
                    'description' => 'Faculte de la connaissance de Dieu',
                    'employee_count' => 5
                ],
                [
                    'name' => 'FSD',
                    'description' => 'Faculte du Service de Dieu',
                    'employee_count' => 7
                ],
                
            ],
            'UMPJ' => [
                [
                    'name' => 'FR',
                    'description' => 'Faculte de Priere',
                    'employee_count' => 8
                ],
                [
                    'name' => 'FVMF',
                    'description' => 'Faculte de Vie et de Marche avec Foi',
                    'employee_count' => 10
                ]
            ],
            'WCS' => [
                [
                    'name' => 'Comptabilité',
                    'description' => 'Service de comptabilité générale',
                    'employee_count' => 5
                ],
                [
                    'name' => 'Audit',
                    'description' => 'Service d\'audit interne',
                    'employee_count' => 6
                ]
            ],
            'CPJCM' => [
                [
                    'name' => 'Priere',
                    'description' => 'Priere Pour la conquete du monde',
                    'employee_count' => 10
                ],
                [
                    'name' => 'Jeune',
                    'description' => 'Jeune pour la conquete du monde',
                    'employee_count' => 10
                ]
            ]
        ];

        foreach ($servicesByDepartment as $deptCode => $services) {
            $department = Department::where('name', $deptCode)->first();
            
            if ($department) {
                foreach ($services as $serviceData) {
                    // Créer le service
                    $service = Service::firstOrCreate(
                        [
                            'name' => $serviceData['name'],
                            'department_id' => $department->id
                        ],
                        [
                            'description' => $serviceData['description']
                        ]
                    );

                    // Créer le manager du service
                    $manager = User::firstOrCreate(
                        [
                            'email' => strtolower(str_replace(' ', '.', $serviceData['name'])) . '.manager@ztf.com'
                        ],
                        [
                            'name' => 'Manager ' . $serviceData['name'],
                            'password' => bcrypt('password'),
                            'matricule' => 'MGR-' . $deptCode . '-' . str_pad($service->id, 3, '0', STR_PAD_LEFT),
                            'department_id' => $department->id,
                            'service_id' => $service->id
                        ]
                    );

                    // Créer les employés du service
                    for ($i = 1; $i <= $serviceData['employee_count']; $i++) {
                        User::firstOrCreate(
                            [
                                'email' => strtolower(str_replace(' ', '.', $serviceData['name'])) . '.emp' . $i . '@ztf.com'
                            ],
                            [
                                'name' => 'Employé ' . $i . ' ' . $serviceData['name'],
                                'password' => bcrypt('password'),
                                'matricule' => 'EMP-' . $deptCode . '-' . str_pad($service->id . $i, 3, '0', STR_PAD_LEFT),
                                'department_id' => $department->id,
                                'service_id' => $service->id
                            ]
                        );
                    }
                }
            }
        }
    }
}