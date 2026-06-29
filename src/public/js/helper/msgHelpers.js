'use strict';

export const messageContainer = document.getElementById('alertMessage');
export const messageSpan = document.getElementById('alertSpanMessage');

// Helper function to show messages
export function showMessage(message, type) {
    messageSpan.textContent = message;
    messageContainer.classList.remove('d-none'); 
    messageContainer.classList.add(type);
    
    // Clear message after 5 seconds
    setTimeout(() => {
        messageContainer.classList.remove(type);
        messageContainer.classList.add('d-none');
    }, 5000);
}
