document.addEventListener("DOMContentLoaded", function() {
    const formSteps = document.querySelectorAll(".form-step");
    const nextBtn = document.getElementById("nextBtn");
    const prevBtn = document.getElementById("prevBtn");
    const submitBtn = document.getElementById("submitBtn");
    const progressSteps = document.querySelectorAll(".progress-step");
    const progressLines = document.querySelectorAll(".progress-line");
    const registrationForm = document.getElementById("registrationForm");
    let currentStep = 0;

    console.log("Total steps:", formSteps.length);
    console.log("Form steps found:", formSteps);

    function showStep(step) {
        console.log("Showing step:", step);
        
        // Cacher toutes les étapes
        formSteps.forEach((formStep, index) => {
            if (index === step) {
                formStep.classList.add("active");
                console.log("Step", index, "is now active");
            } else {
                formStep.classList.remove("active");
            }
        });
        
        // Gérer l'affichage des boutons
        if (step === 0) {
            prevBtn.style.display = "none";
        } else {
            prevBtn.style.display = "inline-block";
        }
        
        if (step === formSteps.length - 1) {
            nextBtn.style.display = "none";
            submitBtn.style.display = "inline-block";
        } else {
            nextBtn.style.display = "inline-block";
            submitBtn.style.display = "none";
        }

        // Mettre à jour la barre de progression
        progressSteps.forEach((progressStep, index) => {
            progressStep.classList.remove("active-step", "completed-step");
            
            if (index === step) {
                progressStep.classList.add("active-step");
            } else if (index < step) {
                progressStep.classList.add("completed-step");
            }
        });
        
        // Mettre à jour les lignes de progression
        progressLines.forEach((line, index) => {
            if (index < step) {
                line.classList.add("completed-line");
            } else {
                line.classList.remove("completed-line");
            }
        });

        // Scroll vers le haut
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Bouton Next
    nextBtn.addEventListener("click", function(e) {
        e.preventDefault();
        console.log("Next clicked, current step:", currentStep);
        
        if (currentStep < formSteps.length - 1) {
            currentStep++;
            showStep(currentStep);
            console.log("Moved to step:", currentStep);
        }
    });

    // Bouton Previous
    prevBtn.addEventListener("click", function(e) {
        e.preventDefault();
        console.log("Previous clicked, current step:", currentStep);
        
        if (currentStep > 0) {
            currentStep--;
            showStep(currentStep);
            console.log("Moved to step:", currentStep);
        }
    });

    // Soumission du formulaire
    submitBtn.addEventListener("click", function(e) {
        e.preventDefault();
        console.log("Form submitting...");
        
        // Vérifier le consentement GDPR
        const gdprConsent = document.querySelector('input[name="gdprConsent"]');
        if (!gdprConsent.checked) {
            alert("Veuillez accepter les conditions GDPR avant de soumettre.");
            return;
        }
        
        // Afficher un loader
        submitBtn.disabled = true;
        submitBtn.textContent = "⏳ Génération du PDF...";

        // Soumettre le formulaire via AJAX pour gérer la réponse JSON
        const formData = new FormData(registrationForm);
        // Ajouter l'action du bouton
        formData.append('action', 'download_pdf');
        
        console.log("Sending fetch to:", registrationForm.action);
        
        fetch(registrationForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log("Response status:", response.status);
            return response.json();
        })
        .then(data => {
            console.log("Response data:", data);
            
            if (data.success || data.download_url) {
                // PDF généré avec succès
                alert("✅ Formulaire enregistré et PDF généré avec succès !\n\n📧 Un email a été envoyé à votre adresse pour vous demander de vous rendre à la cellule informatique.\n\n📥 Votre PDF est en cours de téléchargement...");
                
                // Télécharger le PDF directement (sans ouvrir popup)
                if (data.download_url) {
                    const link = document.createElement('a');
                    link.href = data.download_url;
                    link.download = 'formulaire_staff.pdf';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
                
                // Rediriger vers la page de login pour accéder au dashboard après 3 secondes
                setTimeout(() => {
                    window.location.href = '/login';
                }, 3000);
            } else if (data.errors) {
                // Erreurs de validation
                alert("❌ Erreurs de validation :\n\n" + Object.values(data.errors).flat().join('\n'));
                submitBtn.disabled = false;
                submitBtn.textContent = "Finish & Download PDF";
            } else {
                // Erreur générale
                alert("❌ Erreur : " + (data.error || data.message || "Une erreur est survenue"));
                submitBtn.disabled = false;
                submitBtn.textContent = "Finish & Download PDF";
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);
            alert("❌ Erreur lors de la soumission du formulaire : " + error.message);
            submitBtn.disabled = false;
            submitBtn.textContent = "Finish & Download PDF";
        });
    });

    // Initialisation - afficher la première étape
    console.log("Initializing form...");
    showStep(currentStep);
});