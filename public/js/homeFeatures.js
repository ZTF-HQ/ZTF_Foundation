document.querySelectorAll('.flip-card').forEach(card => {
        let isAnimating = false;
 
        card.addEventListener('click', () => {
            if (isAnimating) return; // bloque les clics pendant l'animation
 
            isAnimating = true;
            card.classList.toggle('is-flipped');
 
            // attend la fin de la transition (650ms) avant de réactiver
            setTimeout(() => {
                isAnimating = false;
            }, 650);
        });
    });