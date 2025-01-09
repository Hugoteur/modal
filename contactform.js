document.addEventListener('DOMContentLoaded', () => {
    const openButton = document.getElementById('openContactModal');
    const modal = document.getElementById('contactModal');
    const closeButton = document.getElementById('closeModalButton');
    const form = document.getElementById('customContactForm');
    const feedback = document.getElementById('formFeedback');

    // Open the modal
    if (openButton) {
        openButton.addEventListener('click', () => {
            modal.style.display = 'block';
        });
    }

    // Close the modal
    if (closeButton) {
        closeButton.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    }

    // Close the modal when clicking outside the content
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Handle form submission
    if (form) {
        form.addEventListener('submit', (event) => {
            event.preventDefault(); // Prevent default form submission

            // Validate GDPR consent
            const gdprCheckbox = form.querySelector('input[name="psgdpr_consent_checkbox"]');
            if (gdprCheckbox && !gdprCheckbox.checked) {
                feedback.innerHTML = '<p class="error">You must agree to the GDPR terms before submitting.</p>';
                return;
            }

            // Prepare form data
            const formData = new FormData(form);

            // Use the dynamically defined ajaxUrl
            fetch(ajaxUrl, {
                method: 'POST',
                body: formData,
            })
                .then((response) => {
                    // Handle the response as JSON
                    if (response.headers.get('content-type').includes('application/json')) {
                        return response.json();
                    } else {
                        throw new Error('Unexpected response format');
                    }
                })
                .then((data) => {
                    if (data.success) {
                        feedback.innerHTML = `<p>${data.message}</p>`;
                        form.reset(); // Clear the form on success
                    } else {
                        feedback.innerHTML = `<p class="error">${data.error}</p>`;
                    }
                })
                .catch((error) => {
                    console.error('AJAX Error:', error); // Log errors for debugging
                    feedback.innerHTML = '<p class="error">An error occurred. Please try again later.</p>';
                });
        });
    }
});
