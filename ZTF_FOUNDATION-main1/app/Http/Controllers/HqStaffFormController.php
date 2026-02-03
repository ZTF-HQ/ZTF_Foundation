<?php

namespace App\Http\Controllers;

use App\Models\HqStaffForm;
use App\Models\StaffPdf;
use App\Mail\StaffFormSubmittedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class HqStaffFormController extends Controller
{
    /**
     * Afficher le formulaire
     */
    public function showBigForm()
    {
        return view('formulaire.create');
    }

    /**
     * Enregistrer les données
     */
    public function store(Request $request)
    {
        try {
            // Validation complète de TOUS les champs
            $validatedData = $request->validate([
                // Étape 1 : Personal Information
                'fullName' => 'required|string|max:255',
                'fathersName' => 'nullable|string|max:255',
                'mothersName' => 'nullable|string|max:255',
                'dateOfBirth' => 'nullable|date',
                'placeOfBirth' => 'nullable|string|max:255',
                'idPassportNumber' => 'nullable|string|max:255',

                // Étape 2 : Contact & Location
                'email' => 'required|string|email|max:255',
                'fullAddress' => 'nullable|string',
                'phoneNumber' => 'nullable|string|max:20',
                'whatsappNumber' => 'nullable|string|max:20',
                'region' => 'nullable|string|max:255',
                'placeOfResidence' => 'nullable|string|max:255',
                'departmentOfOrigin' => 'nullable|string|max:255',
                'village' => 'nullable|string|max:255',
                'ethnicity' => 'nullable|string|max:255',
                'numberOfSiblings' => 'nullable|integer|min:0',
                'nextOfKinName' => 'nullable|string|max:255',
                'nextOfKinCity' => 'nullable|string|max:255',
                'nextOfKinContact' => 'nullable|string|max:20',
                'familyHeadName' => 'nullable|string|max:255',
                'familyHeadCity' => 'nullable|string|max:255',
                'familyHeadContact' => 'nullable|string|max:20',

                // Étape 3 : Spiritual Life
                'conversionDate' => 'nullable|date',
                'baptismByImmersion' => 'nullable|in:Yes,No',
                'baptismInHolySpirit' => 'nullable|in:Yes,No',
                'homeChurch' => 'nullable|string|max:255',
                'center' => 'nullable|string|max:255',
                'discipleMakerName' => 'nullable|string|max:255',
                'discipleMakerContact' => 'nullable|string|max:20',
                'spiritualParentageName' => 'nullable|string|max:255',
                'spiritualParentageContact' => 'nullable|string|max:20',
                'spiritualParentageRelationship' => 'nullable|string',
                'testimony' => 'nullable|string',

                // Étape 4 : Family Life
                'maritalStatus' => 'nullable|in:Married,Single,Engaged',
                'spouseName' => 'nullable|string|max:255',
                'spouseContact' => 'nullable|string|max:20',
                'numberOfLegitimateChildren' => 'nullable|integer|min:0',
                'legitimateChildrenDetails' => 'nullable|string',
                'numberOfDependents' => 'nullable|integer|min:0',
                'dependentsDetails' => 'nullable|string',
                'siblingsDetails' => 'nullable|string',

                // Étape 5 : Professional Life
                'educationFinancer' => 'nullable|string|max:255',
                'educationLevel' => 'nullable|string|max:255',
                'degreeObtained' => 'nullable|string|max:255',
                'activityBeforeHQ' => 'nullable|string',
                'hqEntryDate' => 'nullable|date',
                'hqDepartment' => 'nullable|string|max:255',
                'originCountryCity' => 'nullable|string|max:255',
                'departmentResponsibility' => 'nullable|string',

                // Étape 6 : Commissioning
                'whoIntroducedToHQ' => 'nullable|string',
                'callOfGod' => 'nullable|in:Yes,No',
                'whatCallConsistsOf' => 'nullable|string',
                'familyAwareOfCall' => 'nullable|in:Yes,No',
                'emergencyContactDeath' => 'nullable|string|max:255',
                'burialLocation' => 'nullable|string|max:255',

                // Étape 7 : Possessions & Health
                'yourPossessions' => 'nullable|string',
                'sourcesOfIncome' => 'nullable|string',
                'healthProblems' => 'nullable|string',
                'underTreatment' => 'nullable|in:Yes,No',
                'operationsDetails' => 'nullable|string',

                // Étape 8 : Judicial History
                'problemsWithAnyone' => 'nullable|in:Yes,No',
                'reasonForProblems' => 'nullable|string',
                'beenToPrison' => 'nullable|in:Yes,No',
                'reasonForPrison' => 'nullable|string',

                // Étape 9 : Documents (validation des fichiers)
                'bulletin3File' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'medicalCertificateHopeClinicFile' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'diplomasFile' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'birthMarriageCertificatesFile' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'cniFile' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'familyCommitmentCallFile' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'familyBurialAgreementFile' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

                // GDPR Consent
                'gdprConsent' => 'required|accepted',
            ]);

            // Ajouter l'utilisateur connecté
            if (Auth::check()) {
                $validatedData['user_id'] = Auth::id();
            }

            // Traiter les fichiers uploadés
            $validatedData['bulletin3_path'] = $this->handleFileUpload($request, 'bulletin3File');
            $validatedData['medical_certificate_path'] = $this->handleFileUpload($request, 'medicalCertificateHopeClinicFile');
            $validatedData['diplomas_path'] = $this->handleFileUpload($request, 'diplomasFile');
            $validatedData['birth_marriage_certificates_path'] = $this->handleFileUpload($request, 'birthMarriageCertificatesFile');
            $validatedData['cni_path'] = $this->handleFileUpload($request, 'cniFile');
            $validatedData['family_commitment_path'] = $this->handleFileUpload($request, 'familyCommitmentCallFile');
            $validatedData['family_burial_agreement_path'] = $this->handleFileUpload($request, 'familyBurialAgreementFile');

            // Créer l'enregistrement dans la base de données
            $staffForm = HqStaffForm::create($validatedData);

            // Si le bouton PDF est cliqué (action=download_pdf)
            if ($request->input('action') === 'download_pdf') {
                return $this->telechargerPDF($staffForm->id);
            }

            // Sinon, réponse standard (pour les demandes AJAX)
            return response()->json([
                'success' => true,
                'message' => 'Form saved successfully',
                'staffForm' => $staffForm
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Form store error', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'An error occurred while saving the form: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Traiter l'upload de fichiers
     */
    private function handleFileUpload(Request $request, $fieldName)
    {
        if ($request->hasFile($fieldName)) {
            try {
                $file = $request->file($fieldName);
                $path = $file->store('staff_documents', 'public');
                return $path;
            } catch (\Exception $e) {
                Log::error('File upload failed', ['field' => $fieldName, 'error' => $e->getMessage()]);
                return null;
            }
        }
        return null;
    }

    /**
     * Télécharger le PDF (méthode appelée par la route POST /download-pdf)
     */
    public function telechargerPDF($id = null)
    {
        try {
            // Si $id est null, c'est un POST depuis le formulaire
            // On récupère l'ID depuis la request
            if ($id === null) {
                // Ce cas ne devrait pas arriver car nous passons l'ID
                return response()->json(['error' => 'Invalid request'], 400);
            }

            $staffForm = HqStaffForm::findOrFail($id);

            // Générer le PDF avec les données complètes du formulaire
            $pdf = Pdf::loadView('formulaire.pdf', $staffForm->toArray())
                ->setPaper('a4', 'portrait');

            $filename = 'HQ_Staff_Form_' . $staffForm->id . '_' . time() . '.pdf';
            $pdfPath = 'pdfs/staff_forms/' . $filename;

            // Vérifier que le dossier existe
            Storage::disk('public')->makeDirectory('pdfs/staff_forms', 0755, true);

            // Sauvegarder le PDF
            Storage::disk('public')->put($pdfPath, $pdf->output());

            // Enregistrer le téléchargement si l'utilisateur est connecté
            if (Auth::check()) {
                $pdfRecord = StaffPdf::create([
                    'user_id'  => Auth::id(),
                    'filename' => $filename,
                    'pdf_file' => $pdfPath,
                ]);
                
                // Envoyer l'email à l'utilisateur
                try {
                    Mail::to(Auth::user()->email)->send(new StaffFormSubmittedMail(
                        $staffForm->fullName,
                        Auth::user()->email
                    ));
                    Log::info('Email sent successfully for staff form ID: ' . $staffForm->id);
                } catch (\Exception $e) {
                    Log::error('Failed to send email for staff form ID: ' . $staffForm->id . ' - Error: ' . $e->getMessage());
                }
            } else {
                // Si pas connecté, envoyer quand même l'email avec l'adresse du formulaire
                $userEmail = $staffForm->email ?? null;
                if ($userEmail) {
                    try {
                        Mail::to($userEmail)->send(new StaffFormSubmittedMail(
                            $staffForm->fullName,
                            $userEmail
                        ));
                        Log::info('Email sent successfully for staff form ID: ' . $staffForm->id);
                    } catch (\Exception $e) {
                        Log::error('Failed to send email for staff form ID: ' . $staffForm->id . ' - Error: ' . $e->getMessage());
                    }
                }
            }

            // Retourner une réponse JSON avec l'URL de téléchargement (PUBLIC - sans authentification)
            return response()->json([
                'success' => true,
                'message' => 'PDF generated successfully',
                'download_url' => route('public.pdf', ['filename' => $filename]),
                'redirect_url' => route('pdf.download.history')
            ], 200);

        } catch (\Exception $e) {
            Log::error('PDF generation failed', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json([
                'error' => 'PDF generation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Télécharger le PDF depuis la base (direct download)
     */
    public function downloadPDF($id)
    {
        try {
            $staffForm = HqStaffForm::findOrFail($id);

            $pdf = Pdf::loadView('formulaire.pdf', $staffForm->toArray())
                ->setPaper('a4', 'portrait');

            $filename = 'HQ_Staff_Form_' . $staffForm->id . '_' . time() . '.pdf';
            $pdfPath = 'pdfs/staff_forms/' . $filename;

            Storage::disk('public')->makeDirectory('pdfs/staff_forms', 0755, true);
            Storage::disk('public')->put($pdfPath, $pdf->output());

            if (Auth::check()) {
                StaffPdf::create([
                    'user_id'  => Auth::id(),
                    'filename' => $filename,
                    'pdf_file' => $pdfPath,
                ]);
            }

            return response()->download(
                storage_path('app/public/' . $pdfPath),
                $filename
            );
        } catch (\Exception $e) {
            Log::error('PDF download failed', ['id' => $id, 'error' => $e->getMessage()]);
            abort(500, 'PDF generation failed');
        }
    }


    /**
     * Télécharger PDF par utilisateur
     */
    public function downloadUserStaffPDF($userId)
    {
        $staffForm = HqStaffForm::where('user_id', $userId)->firstOrFail();
        return $this->downloadPDF($staffForm->id);
    }

    /**
     * Télécharger PDF par ID utilisateur (alternative)
     */
    public function downloadUserPDF($id)
    {
        $staffForm = HqStaffForm::where('user_id', $id)->firstOrFail();
        return $this->downloadPDF($staffForm->id);
    }

    /**
     * Historique des téléchargements de PDF
     */
    public function downloadHistory()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $pdfs = StaffPdf::where('user_id', Auth::id())->latest()->get();
        return view('pdf.download_history', compact('pdfs'));
    }

    /**
     * Retélécharger un PDF depuis l'historique
     */
    public function redownloadPDF($id)
    {
        try {
            $pdf = StaffPdf::findOrFail($id);

            if ($pdf->user_id !== Auth::id()) {
                abort(403, 'Unauthorized');
            }

            if (!Storage::disk('public')->exists($pdf->pdf_file)) {
                abort(404, 'PDF file not found');
            }

            return response()->download(
                storage_path('app/public/' . $pdf->pdf_file),
                $pdf->filename
            );
        } catch (\Exception $e) {
            Log::error('PDF redownload failed', ['id' => $id, 'error' => $e->getMessage()]);
            abort(500, 'Download failed');
        }
    }

    /**
     * Approuver un lien de PDF (pour les administrateurs)
     */
    public function approvePDFLink($staffUserId)
    {
        // À implémenter selon votre logique métier
        return response()->json(['message' => 'PDF link approved'], 200);
    }

    /**
     * Rejeter un lien de PDF (pour les administrateurs)
     */
    public function rejectPDFLink($staffUserId)
    {
        // À implémenter selon votre logique métier
        return response()->json(['message' => 'PDF link rejected'], 200);
    }

    /**
     * Voir les approbations de PDF en attente
     */
    public function pendingApprovals()
    {
        // À implémenter selon votre logique métier
        return view('pdf.pending_approvals');
    }
}
