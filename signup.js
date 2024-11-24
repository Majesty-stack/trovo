const skilledWorker = document.querySelector('.btn-skilled-wrk');
const client = document.querySelector('.btn-client');
const signUp = document.querySelector('.btn-signup');

// Add event listeners to the buttons
skilledWorker.addEventListener('click', () => {
    console.log('Skilled worker button clicked');
});

client.addEventListener('click', () => {
    // Handle SMS-based password reset logic here
    console.log('Client button clicked');
});

signUp.addEventListener('click', () => {
    // Handle general password reset logic here
    console.log('signup button clicked');
});
