'use strict';

const logoutForm = document.getElementById('logoutForm');
const messageContainer = document.getElementById('alertMessage');
const messageSpan = document.getElementById('alertSpanMessage');


// Add submit event listener
logoutForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent traditional form submission
    
    // Make AJAX call with Fetch API
    fetch(logoutForm.action, {
        method: logoutForm.method.toUpperCase(),
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => {
        if (!response.ok) {
            // Handle different HTTP status codes
            if (response.status === 401) {
                throw new Error('Invalid email or password');
            } else if (response.status === 400) {
                throw new Error('Invalid request format');
            } else {
                throw new Error('Login failed. Please try again.');
            }
        }
        return response.json();
    })
    .then(data => {
        // Handle successful login
        console.log('Logout successful');
        showMessage('Logout successful, wish to see you soon! Redirecting...', 'alert-success');
        
        // Clear storage token
        if (data.token) {
            localStorage.clear();
        }
        
        // Redirect after 2 seconds
        setTimeout(() => {
            window.location.href = '/';
        }, 2000);
    })
    .catch(error => {
        // Handle errors
        console.error('Error:', error);
        showMessage(error.message, 'alert-danger');
    });
});

// Helper function to show messages
function showMessage(message, type) {
    messageSpan.textContent = message;
    messageContainer.classList.remove('d-none'); 
    messageContainer.classList.add(type);
    
    // Clear message after 5 seconds
    setTimeout(() => {
        messageContainer.classList.remove(type);
        messageContainer.classList.add('d-none');
    }, 5000);
}
