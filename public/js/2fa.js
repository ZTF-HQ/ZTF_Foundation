document.addEventListener('DOMContentLoaded', function() {
    // Gestion des étapes
    const steps = document.querySelectorAll('.step');
    const stages = document.querySelectorAll('.form-stage');
    let currentStep = 1;
    let countdown;
    
    // Obtenir le token CSRF depuis le meta tag
    const getCsrfToken = () => {
        const token = document.querySelector('meta[name="csrf-token"]');
        return token ? token.getAttribute('content') : '';
    };
    
    // Fonction pour gérer les formulaires avec Ajax
    function handleForm(formId, nextStep) {
        const form = document.getElementById(formId);
        if (!form) {
            console.error(`Formulaire ${formId} non trouvé`);
            return;
        }
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(form);
            const button = form.querySelector('button[type="submit"]');
            const url = form.getAttribute('action');
            
            if (!url) {
                console.error('URL du formulaire non trouvée');
                alert('Erreur de configuration');
                return;
            }
            
            button.classList.add('loading');

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    if (data.testCode) {
                        // Auto-remplir le code pour le test
                        const codeInput = document.getElementById('code');
                        if (codeInput) {
                            codeInput.value = data.testCode;
                        }
                    }
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        updateSteps(nextStep);
                        // Démarrer le timer si on passe à l'étape 2
                        if (nextStep === 2) {
                            if (countdown) clearInterval(countdown);
                            startTimer(30);
                        }
                    }
                } else {
                    alert(data.message || 'Une erreur est survenue');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue: ' + error.message);
            })
            .finally(() => {
                button.classList.remove('loading');
            });
        });
    }

    function updateSteps(step) {
        steps.forEach(s => {
            const stepNum = parseInt(s.dataset.step);
            if (stepNum < step) {
                s.classList.add('completed');
                s.classList.remove('active');
            } else if (stepNum === step) {
                s.classList.add('active');
                s.classList.remove('completed');
            } else {
                s.classList.remove('active', 'completed');
            }
        });

        stages.forEach((stage, index) => {
            if (index + 1 === step) {
                stage.classList.add('active');
            } else {
                stage.classList.remove('active');
            }
        });
        
        currentStep = step;
    }

    // Formatage automatique du code de vérification
    const codeInput = document.getElementById('code');
    if (codeInput) {
        codeInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 12);
        });
    }

    // Timer
    function startTimer(duration) {
        const countdownDisplay = document.getElementById('countdown');
        if (!countdownDisplay) {
            console.error('Élément countdown non trouvé');
            return;
        }
        
        let timer = duration;
        countdownDisplay.textContent = timer;

        countdown = setInterval(() => {
            timer--;
            countdownDisplay.textContent = timer;
            
            if (timer < 0) {
                clearInterval(countdown);
                alert('Le code a expiré. Veuillez demander un nouveau code.');
                updateSteps(1);
                // Réinitialiser le formulaire
                const emailForm = document.getElementById('emailForm');
                if (emailForm) emailForm.reset();
            }
        }, 1000);
    }

    // Initialiser les gestionnaires de formulaire
    handleForm('emailForm', 2);
    handleForm('verificationForm', 3);

    // Nettoyage lors de la destruction
    window.addEventListener('beforeunload', () => {
        if (countdown) clearInterval(countdown);
    });
});
