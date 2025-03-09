document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const submitButton = this.querySelector('button[type="submit"]');
    const form = this;
    submitButton.disabled = true;
    submitButton.textContent = 'Sending...';

    const formData = new FormData(this);

    fetch(this.action, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text();
    })
    .then(data => {
        if (data && data.includes('Message has been sent')) {
            form.style.display = 'none';
            document.getElementById('confirmationMessage').style.display = 'block';
        } else {
            throw new Error('Invalid server response');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        submitButton.disabled = false;
        submitButton.textContent = 'Send Message';
        alert('There was an error sending your message. Please try again.');
    });
});

function resetForm() {
    const form = document.getElementById('contactForm');
    const confirmationMessage = document.getElementById('confirmationMessage');
    form.reset();
    form.style.display = 'block';
    confirmationMessage.style.display = 'none';
    form.querySelector('button[type="submit"]').textContent = 'Send Message';
    form.querySelector('button[type="submit"]').disabled = false;
}

function resetFormAndRedirect() {
    resetForm();
    window.location.href = '/';
}