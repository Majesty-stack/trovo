function togglePasswordVisibility() {
    var passwordField = document.getElementById("writeP");
    var toggleIcon = document.querySelector(".toggle-password i");
    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
};




function validateForm() {
  // Get form elements
  const firstName = document.getElementById('writeF').value;
  const lastName = document.getElementById('writeL').value;
  const email = document.getElementById('writeE').value;
  const role = document.getElementById('roles-available').value;
  const password = document.getElementById('writeP').value;

  // Check for empty fields
  if (!firstName || !lastName || !email || !role || !password) {
    alert('Please fill out all required fields.');
    return false;
  }

  // Email validation (basic regex check)
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(email)) {
    alert('Invalid email address.');
    return false;
  }

  // Password strength (basic check)
  if (password.length < 8) {
    alert('Password must be at least 8 characters long.');
    return false;
  }

  const hasUppercase = /[A-Z]/.test(password);
  const hasNumber = /[0-9]/.test(password);

  if (!hasUppercase || !hasNumber) {
    alert('Password must contain at least one uppercase letter and one number.');
    return false;
  }

  // Additional checks for password complexity can be added here

  // If all checks pass, submit the form
  return true;
}

function submitForm() {
    if (validateForm()) {
        // Get form data
        const formData = new FormData(document.getElementById('myForm'));

        // Send the data to the server (example using fetch)
        fetch('/your-server-endpoint', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            // Handle successful submission (e.g., show success message, redirect)
            console.log('Form submitted successfully.');
            // You might want to redirect the user to a different page or show a success message.
        })
        .catch(error => {
            // Handle errors (e.g., show error message)
            console.error('Error submitting form:', error);
            alert('An error occurred. Please try again later.');
        });
    }
}
