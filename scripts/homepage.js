document.querySelectorAll('swipe-effect').addEventListener('click', function(e) {
    e.preventDefault(); // Prevent the default redirect for now

    const swipe = document.querySelector('.swipe');
    
    // Trigger the swipe animation
    swipe.classList.add('active');
    
    // Wait for the animation to finish before redirecting
    setTimeout(function() {
        window.location.href = e.target.href; // Perform the redirection
    }, 500); // Match the duration of the animation (0.5s)
});
