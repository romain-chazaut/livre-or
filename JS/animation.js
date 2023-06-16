window.addEventListener('DOMContentLoaded', (event) => {
    const submitButton = document.querySelector('input[name="new_comment"]');
    const form = document.querySelector('form');

    submitButton.addEventListener('click', (e) => {
        e.preventDefault();
        submitButton.style.position = 'relative';
        submitButton.style.top = '0px';
        let direction = 1;

        const id = setInterval(frame, 5);
        function frame() {
            if (parseInt(submitButton.style.top) == 20) {
                direction = -1;
            } else if (parseInt(submitButton.style.top) == 0) {
                direction = 1;
                clearInterval(id); // Stop the animation
                form.submit(); // Manually submit the form
            }
            submitButton.style.top = parseInt(submitButton.style.top) + direction + 'px';
        }
    });
});
