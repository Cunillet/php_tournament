'use strict';

const registerForm = document.getElementById('registerForm');
const messageContainer = document.getElementById('alertMessage');
const messageSpan = document.getElementById('alertSpanMessage');

const isValidEmail = (email) => {
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  return regex.test(email)
}

// Add submit event listener
registerForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent traditional form submission
    
    // Get form values
    const email = document.getElementById('user_email').value;
    const password = document.getElementById('user_password').value;
    const name = document.getElementById('user_name').value;
    
    // Basic validation
    if (!email || !password || !name ||
        email.length < 3 || password.length < 3 || name.length < 3 ||
        !isValidEmail(email)) {
        showMessage('Please fill in all fields and check they have valid constructions', 'alert-danger');
        return;
    }
    
    // Create data object from form
    const registerData = {
        email: email,
        password: password,
        name: name
    };
    
    // Make AJAX call with Fetch API
    fetch(registerForm.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(registerData)
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
