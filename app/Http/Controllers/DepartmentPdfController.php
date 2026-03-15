<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF;

class DepartmentPdfController extends Controller
{
    public function generatePDF(Request $request)
    {
        // Vérifier si l'utilisateur est chef de département
        if (!Auth::user()->isAdmin2()) {
            return back()->with('error', 'Accès non autorisé');
        }

        // Récupérer le département de l'utilisateur connecté
        $department = Department::with([
            'head',
            'services.users' => function($query) {
                $query->select('users.id', 'users.name', 'users.matricule', 'users.phone', 'users.service_id')
                    ->with('roles:id,name')
                    ->orderBy('users.name');
            }
        ])->find(Auth::user()->department_id);

        if (!$department) {
            return back()->with('error', 'Département non trouvé');
        }

        // Configuration de DomPDF
        $config = [
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => false,
            'isRemoteEnabled' => true,
            'dpi' => 96,
            'fontCache' => storage_path('fonts'),
            'tempDir' => storage_path('app/pdf-temp'),
            'chroot' => public_path(),
        ];

        // Générer le PDF avec options
        $pdf = PDF::loadView('departments.pdfs.department-report', compact('department'))
            ->setOptions($config);
        $pdf->setPaper('A4');
        
        // Nom du fichier
        $date = now();
        $filename = 'Liste_Des_Ouvriers_par_Service_' . 
            $department->code . '_Telecharger_le_' . 
            $date->format('Y_m_d') . '_A_' . 
            $date->format('H:i:s') . '.pdf';
        
        // Générer le contenu du PDF
        $pdfContent = $pdf->output();
        
        //Assainir le nom du department pour le chemin du fichier
        $safeName = Str::slug($department->name);

        // chemin du fichier
        $path = 'pdfs/department/'. $department->id.'/'.$safeName.'/'.$filename;

        //

        Storage::disk('public')->put($path,$pdfContent);

        return response($pdfContent, 200,[
        'Content-Type'=>'application/pdf',
        'Content-Disposition'=>'attachement; filename="' . $filename . '"',
        'Content-Lenght'=>strlen($pdfContent),
        ]);
        
    }

    public function getPdfHistory()
    {
        if (!Auth::user()->isAdmin2()) {
            return back()->with('error', 'Accès non autorisé');
        }

        // Récupérer le département de l'utilisateur
        $department = Department::find(Auth::user()->department_id);
        if (!$department) {
            return back()->with('error', 'Département non trouvé');
        }

        // Récupérer les PDFs du département spécifique
        $departmentPath = 'pdfs/departments/' . $department->id;
        
        // Vérifier si le dossier existe
        if (!Storage::disk('public')->exists($departmentPath)) {
            $pdfs = [];
        } else {
            $pdfs = collect(Storage::disk('public')->files($departmentPath))
                ->filter(function($file) {
                    return pathinfo($file, PATHINFO_EXTENSION) === 'pdf';
                })
                ->sortByDesc(function($file) {
                    return Storage::disk('public')->lastModified($file);
                })
                ->values()
                ->all();
        }

        return view('departments.pdfs.history', [
            'pdfs' => $pdfs,
            'departmentName' => $department->name
        ]);
    }
}