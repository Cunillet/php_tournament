'use strict';

const loginForm = document.getElementById('loginForm');
const messageContainer = document.getElementById('alertMessage');
const messageSpan = document.getElementById('alertSpanMessage');

const isValidEmail = (email) => {
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  return regex.test(email)
}

// Add submit event listener
loginForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent traditional form submission
    
    // Get form values
    const email = document.getElementById('inputEmail').value;
    const password = document.getElementById('inputPassword').value;
    
    // Basic validation
    if (!email || !password ||
        email.length < 3 || password.length < 3 ||
        !isValidEmail(email)) {
        showMessage('Please fill in all fields and check they have valid constructions', 'alert-danger');
        return;
    }
    
    // Create data object from form
    const loginData = {
        email: email,
        password: password
    };
    
    // Make AJAX call with Fetch API
    fetch(loginForm.action, {
        method: loginForm.method.toUpperCase(),
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
        return response;
    })
    .then(data => {
        // Handle successful login
        console.log('Login successful:', data);
        showMessage('Login successful! Redirecting...', 'alert-success');
        
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
