<?php

namespace App\Http\Controllers;

use App\Models\HqStaffForm;
use App\Models\StaffPdf;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Charger l'utilisateur avec ses relations
        $user->load([
            'department',
            'services',
            'roles'
        ]);

        // Statistiques personnelles du staff
        $totalFormsSubmitted = HqStaffForm::where('email', $user->email)->count();
        $totalPDFsGenerated = StaffPdf::where('user_id', $user->id)->count();
        
        // Récupérer le dernier formulaire soumis
        $lastForm = HqStaffForm::where('email', $user->email)
            ->orderBy('created_at', 'desc')
            ->first();
        
        // Récupérer les formulaires soumis récemment
        $recentForms = HqStaffForm::where('email', $user->email)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Récupérer les PDFs téléchargés
        $staffPdfs = StaffPdf::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Déterminer le statut du profil
        $profileCompletion = $this->calculateProfileCompletion($user);
        
        // Activités récentes
        $recentActivities = [
            'last_login' => $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Jamais',
            'last_activity' => $user->last_activity_at ? $user->last_activity_at->diffForHumans() : 'Jamais',
            'profile_updated' => $user->info_updated_at ? $user->info_updated_at->diffForHumans() : 'Jamais',
            'is_online' => $user->last_activity_at ? \Carbon\Carbon::parse($user->last_activity_at)->gt(now()->subMinutes(15)) : false,
        ];

        // Nombre de collègues dans le même département
        $departmentColleagues = $user->department 
            ? $user->department->users->where('id', '!=', $user->id)->count() 
            : 0;

        // Nombre de services assignés
        $totalServices = $user->services->count();

        return view('staff.dashboard', compact(
            'user',
            'totalFormsSubmitted',
            'totalPDFsGenerated',
            'recentForms',
            'staffPdfs',
            'profileCompletion',
            'recentActivities',
            'departmentColleagues',
            'totalServices',
            'lastForm'
        ));
    }

    /**
     * Télécharger le formulaire du staff depuis le dashboard
     */
    public function downloadForm($formId)
    {
        $user = Auth::user();
        $form = HqStaffForm::findOrFail($formId);

        // Vérifier que le formulaire appartient à l'utilisateur
        if ($form->email !== $user->email) {
            abort(403, 'Accès refusé');
        }

        try {
            $pdf = Pdf::loadView('formulaire.pdf', $form->toArray())
                ->setPaper('a4', 'portrait');

            $filename = 'HQ_Staff_Form_' . $form->id . '_' . now()->format('YmdHis') . '.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors du téléchargement: ' . $e->getMessage());
        }
    }

    /**
     * Calcule le pourcentage de complétude du profil
     */
    private function calculateProfileCompletion($user)
    {
        $fields = [
            'name',
            'email',
            'phone',
            'department_id',
        ];

        $filled = 0;
        foreach ($fields as $field) {
            if (!empty($user->$field)) {
                $filled++;
            }
        }

        return round(($filled / count($fields)) * 100);
    }
}
