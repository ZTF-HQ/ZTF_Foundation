 document.addEventListener('DOMContentLoaded', function() {
        // Gestion des inputs du code
        const codeInputs = document.querySelectorAll('.code-digit');
        const form = document.querySelector('form');

        codeInputs.forEach((input, index) => {
            // Déplacement automatique au champ suivant
            input.addEventListener('input', function(e) {
                if (input.value.length === input.maxLength) {
                    if (index < codeInputs.length - 1) {
                        codeInputs[index + 1].focus();
                    }
                }
            });

            // Gestion de la touche retour arrière
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && input.value.length === 0 && index > 0) {
                    codeInputs[index - 1].focus();
                }
            });
        });

        // Gestion du timer
        let timeLeft = 120; // 2 minutes en secondes
        const timerElement = document.getElementById('timer');

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft > 0) {
                timeLeft--;
                setTimeout(updateTimer, 1000);
            } else {
                timerElement.parentElement.textContent = 'Code expiré';
            }
        }

        updateTimer();

        // Soumission du formulaire
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            let code = '';
            codeInputs.forEach(input => {
                code += input.value;
            });
            document.getElementById('verification_code').value = code;
            this.submit();
        });
    });