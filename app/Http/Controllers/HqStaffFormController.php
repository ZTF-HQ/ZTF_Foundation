<?php

namespace App\Http\Controllers;


use App\Models\HqStaffForm;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class HqStaffFormController extends Controller
{
    /**
     * Affiche le formulaire principal
     */
    public function showBigForm()
    {
        return view('formulaire.create');
    }

    /**
     * Télécharge le PDF du formulaire de l'ouvrier
     */
    public function downloadOuvrierPDF($id)
    {
        try {
            $ouvrier = HqStaffForm::findOrFail($id);
            
            $pdf = Pdf::loadView('formulaire.pdf', compact('ouvrier'));
            
            $filename = 'QG_Ouvrier_N°' . $ouvrier->id . '.pdf';
            
            return $pdf->download($filename);
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors du téléchargement du PDF');
        }
    }



    public function storeForms(Request $request)
{
        $validated = $request->validate([

                //Section 1 : Informations personnelles
                'fullName'     => 'required|string|max:255',
                'fathersName' => 'nullable|string|max:255',
                'mothersName' => 'nullable|string|max:255',
                'dateOfBirth' => 'required|date',
                'placeOfBirth' => 'required|string|max:255',
                'idPassportNumber' => 'nullable|string|max:50',

                // Section 2 : Contact & Location
                'fullAddress' => 'required|string|max:500',
                'phoneNumber' => 'required|string|max:20',
                'whatsappNumber' => 'nullable|string|max:20',
                'region' => 'required|string|max:100',
                'placeOfResidence' => 'required|string|max:255',
                'departmentOfOrigin' => 'required|string|max:255',
                'village' => 'nullable|string|max:255',
                'ethnicity' => 'nullable|string|max:100',
                'numberOfSiblings' => 'nullable|integer|min:0',
                'nextOfKinName' => 'required|string|max:255',
                'nextOfKinCity' => 'required|string|max:255',
                'nextOfKinContact' => 'required|string|max:20',
                'familyHeadName' => 'required|string|max:255',
                'familyHeadCity' => 'required|string|max:255',
                'familyHeadContact' => 'required|string|max:20',

                // Section 3 : Spiritual Life
                'conversionDate' => 'required|date',
                'baptismByImmersion' => 'required|in:Yes,No',
                'baptismInHolySpirit' => 'required|in:Yes,No',
                'homeChurch' => 'required|string|max:255',
                'center' => 'required|string|max:255',
                'discipleMakerName' => 'required|string|max:255',
                'discipleMakerContact' => 'required|string|max:20',
                'spiritualParentageName' => 'required|string|max:255',
                'spiritualParentageContact' => 'required|string|max:20',
                'spiritualParentageRelationship' => 'required|string|max:500',
                'testimony' => 'required|string|max:1000',

                // Section 4 : Family Life
                'maritalStatus' => 'required|in:Married,Single,Engaged',
                'spouseName' => 'nullable|string|max:255',
                'spouseContact' => 'nullable|string|max:20',
                'numberOfLegitimateChildren' => 'nullable|integer|min:0',
                'legitimateChildrenDetails' => 'nullable|string|max:1000',
                'numberOfDependents' => 'nullable|integer|min:0',
                'dependentsDetails' => 'nullable|string|max:1000',
                'siblingsDetails' => 'nullable|string|max:1000',

                // Section 5 : Professional Life
                'educationFinancer' => 'required|string|max:255',
                'educationLevel' => 'required|string|max:255',
                'degreeObtained' => 'nullable|string|max:255',
                'activityBeforeHQ' => 'required|string|max:500',
                'hqEntryDate' => 'required|date',
                'hqDepartment' => 'required|string|max:255',
                'originCountryCity' => 'required|string|max:255',
                'departmentResponsibility' => 'required|string|max:500',

                // Section 6 : Commissioning
                'whoIntroducedToHQ' => 'required|string|max:500',
                'callOfGod' => 'nullable|in:Yes,No',
                'whatCallConsistsOf' => 'nullable|string|max:1000',
                'familyAwareOfCall' => 'nullable|in:Yes,No',
                'emergencyContactDeath' => 'required|string|max:500',
                'burialLocation' => 'required|string|max:500',

                // Section 7 : Possessions & Health
                'yourPossessions' => 'nullable|string|max:1000',
                'sourcesOfIncome' => 'required|string|max:500',
                'healthProblems' => 'nullable|string|max:1000',
                'underTreatment' => 'nullable|in:Yes,No',
                'operationsDetails' => 'nullable|string|max:1000',

                // Section 8 : Judicial History
                'problemsWithAnyone' => 'nullable|in:Yes,No',
                'reasonForProblems' => 'nullable|string|max:1000',
                'beenToPrison' => 'nullable|in:Yes,No',
                'reasonForPrison' => 'nullable|string|max:1000',
            'gdprConsent'  => 'required'
        ]);

        try {
            $ouvrier = HqStaffForm::create($validated);

            $pdf = Pdf::loadView('formulaire.pdf', compact('ouvrier'));

            $path = 'forms/QG_Ouvrier_N°'.$ouvrier->id.'.pdf';

            // Créer le dossier s'il n'existe pas
            Storage::disk('public')->makeDirectory('forms', 0755, true);

            // Sauvegarder le PDF
            Storage::disk('public')->put($path, $pdf->output());

            // Rediriger vers home avec les données
            return redirect()->route('home')->with([
                'registration_success' => true,
                'pdf_path' => $path,
                'ouvrier_id' => $ouvrier->id,
                'ouvrier_name' => $ouvrier->fullName
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'enregistrement du formulaire', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Erreur lors de l\'enregistrement: ' . $e->getMessage())->withInput();
        }
}
}
