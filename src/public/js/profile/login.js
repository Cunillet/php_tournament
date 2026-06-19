'use strict';

const loginForm = document.getElementById('loginForm');
const messageDiv = document.getElementById('message');

const isValidEmail = (email) => {
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  return regex.test(email)
}

// Add submit event listener
loginForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent traditional form submission
    
    // Get form values
    const email = document.getElementById('user_email').value;
    const password = document.getElementById('user_password').value;
    
    // Basic validation
    if (!email || !password ||
        email.length < 3 || password.length < 3 ||
        !isValidEmail(email)) {
        showMessage('Please fill in all fields and check they have valid constructions', 'error');
        return;
    }
    
    // Create data object from form
    const loginData = {
        email: email,
        password: password
    };
    
    // Make AJAX call with Fetch API
    fetch(loginForm.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(loginData)
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
        console.log('Login successful:', data);
        showMessage('Login successful! Redirecting...', 'success');
        
        // Store token if returned
        if (data.token) {
            localStorage.setItem('authToken', data.token);
        }
        
        // Redirect after 2 seconds
        setTimeout(() => {
            window.location.href = '/';
        }, 2000);
    })
    .catch(error => {
        // Handle errors
        console.error('Error:', error);
        showMessage(error.message, 'error');
    });
});

// Helper function to show messages
function showMessage(message, type) {
    messageDiv.textContent = message;
    messageDiv.className = type;
    
    // Clear message after 5 seconds
    setTimeout(() => {
        messageDiv.textContent = '';
        messageDiv.className = '';
    }, 5000);
}