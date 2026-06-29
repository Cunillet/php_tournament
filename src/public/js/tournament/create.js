'use strict';
import { messageContainer, messageSpan, showMessage} from '../helper/msgHelpers.js';

const createForm = document.getElementById('createForm');

// Add submit event listener
createForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent traditional form submission
    
    // Get form values
    const tournamentName = document.getElementById('inputName').value;
    const tournamentGameType = document.getElementById('selectGameType').value;
    
    // Basic validation
    if (!tournamentName || !tournamentGameType|| tournamentName.length < 3) {
        showMessage('Please fill in all fields and check they have valid constructions', 'alert-danger');
        return;
    }
    
    // Create data object from form
    const registerData = {
        name: tournamentName,
        gameType: tournamentGameType,
    };
    
    // Make AJAX call with Fetch API
    fetch(createForm.action, {
        method: createForm.method.toUpperCase(),
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(registerData)
    })
    .then(response => {
        if (!response.ok) {
            // Handle different HTTP status codes
            if (response.status === 401) {
                throw new Error('Invalid game data');
            } else if (response.status === 400) {
                throw new Error('Invalid request format');
            } else {
                throw new Error('Server error, please try again later.');
            }
        }
        return response.json();
    })
    .then(data => {
        // Handle successful login
        console.log('Tournament creation successfull: ', data);
        showMessage('Tournament creation successful! Redirecting...', 'alert-success');
        
        // Store token if returned
        if (data.token) {
            localStorage.setItem('authToken', data.token);
        }
        
        // Redirect after 2 seconds
        setTimeout(() => {
            window.location.href = '/tournaments';
        }, 2000);
    })
    .catch(error => {
        // Handle errors
        console.error('Error:', error);
        showMessage(error.message, 'alert-danger');
    });
});
