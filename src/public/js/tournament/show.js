'use strict';
import { messageContainer, messageSpan, showMessage} from '../helper/msgHelpers.js';

const joinButton = document.getElementById('joinTournament');

// Add submit event listener
joinButton.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent traditional form submission
    let joinTournamentHref = joinButton.href;
    joinButton.removeAttribute('href');
    joinButton.style.opacity = '0.5';
    joinButton.style.cursor = 'default';
    
    // Make AJAX call with Fetch API
    fetch(joinTournamentHref, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
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
        console.log('Tournament joined successfully: ', data);
        showMessage('Tournament Joined successfully! Redirecting...', 'alert-success');
        
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
