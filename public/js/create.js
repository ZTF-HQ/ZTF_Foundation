// Form step navigation
let currentStep = 1;
const totalSteps = 9;

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#registrationForm');
    const prevBtn = document.querySelector('#prevBtn');
    const nextBtn = document.querySelector('#nextBtn');
    const submitBtn = document.querySelector('#submitBtn');

    // Show initial step
    showStep(currentStep);

    // Next button
    if (nextBtn) {
        nextBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (validateStep(currentStep)) {
                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            }
        });
    }

    // Previous button
    if (prevBtn) {
        prevBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    }

    // Form submission
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateStep(currentStep)) {
                e.preventDefault();
            }
            // Permettre la soumission naturelle du formulaire
        });
    }

    // Real-time validation on input
    const inputs = form ? form.querySelectorAll('input, textarea') : [];
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        input.addEventListener('input', function() {
            if (this.classList.contains('error')) {
                validateField(this);
            }
        });
    });
});

// Show/hide steps
function showStep(step) {
    const formSteps = document.querySelectorAll('.form-step');
    const progressSteps = document.querySelectorAll('.progress-step');
    
    // Hide all steps
    formSteps.forEach(s => s.classList.remove('active'));
    progressSteps.forEach(s => s.classList.remove('active-step'));
    
    // Show current step
    if (formSteps[step - 1]) {
        formSteps[step - 1].classList.add('active');
    }
    
    // Update progress
    for (let i = 0; i < step; i++) {
        if (progressSteps[i]) {
            progressSteps[i].classList.add('active-step');
        }
    }

    // Update buttons visibility
    const prevBtn = document.querySelector('#prevBtn');
    const nextBtn = document.querySelector('#nextBtn');
    const submitBtn = document.querySelector('#submitBtn');

    if (prevBtn) {
        prevBtn.style.display = step > 1 ? 'block' : 'none';
    }
    if (nextBtn) {
        nextBtn.style.display = step < totalSteps ? 'block' : 'none';
    }
    if (submitBtn) {
        submitBtn.style.display = step === totalSteps ? 'block' : 'none';
    }
}

// Validate step fields
function validateStep(step) {
    const formSteps = document.querySelectorAll('.form-step');
    const currentFormStep = formSteps[step - 1];
    
    if (!currentFormStep) return true;

    // Valider les champs requis visibles
    const inputs = currentFormStep.querySelectorAll('input[required], textarea[required], select[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (input.type === 'radio') {
            // Pour les radios, vérifier si au moins une option est sélectionnée
            const radioGroup = currentFormStep.querySelectorAll(`input[name="${input.name}"]`);
            const isChecked = Array.from(radioGroup).some(radio => radio.checked);
            if (!isChecked) {
                isValid = false;
                radioGroup.forEach(radio => radio.classList.add('error'));
            }
        } else {
            if (!validateField(input)) {
                isValid = false;
            }
        }
    });

    return isValid;
}

// Validate individual field
function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = '';

    // Required field validation
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = 'Ce champ est obligatoire';
    }
    
    // Email validation
    if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
            errorMessage = 'Veuillez entrer une adresse email valide';
        }
    }
    
    // Phone validation
    if (field.type === 'tel' && value) {
        const phoneRegex = /^[+]?[\d\s-]{8,}$/;
        if (!phoneRegex.test(value)) {
            isValid = false;
            errorMessage = 'Veuillez entrer un numéro de téléphone valide';
        }
    }

    // Update UI
    const container = field.closest('.form-group') || field.parentElement;
    if (container) {
        if (!isValid) {
            field.classList.add('error');
            let errorElement = container.querySelector('.error-message');
            if (!errorElement) {
                errorElement = document.createElement('div');
                errorElement.className = 'error-message';
                container.appendChild(errorElement);
            }
            errorElement.textContent = errorMessage;
        } else {
            field.classList.remove('error');
            const errorElement = container.querySelector('.error-message');
            if (errorElement) {
                errorElement.remove();
            }
        }
    }

    return isValid;
}
