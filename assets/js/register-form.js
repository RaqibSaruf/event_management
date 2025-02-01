document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("registerForm").addEventListener("submit", function (event) {
        event.preventDefault();

        let isValid = true;

        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value.trim();
        const passwordConfirmation = document.getElementById("passwordConfirmation").value.trim();

        const nameError = document.getElementById("nameError");
        const emailError = document.getElementById("emailError");
        const passwordError = document.getElementById("passwordError");
        const passwordConfirmationError = document.getElementById("passwordConfirmationError");

        nameError.textContent = "";
        emailError.textContent = "";
        passwordError.textContent = "";
        passwordConfirmationError.textContent = "";

        // Name validation
        if (name.length < 3) {
            nameError.textContent = "Name must be at least 3 characters";
            isValid = false;
        }else if (name.length > 255) {
            nameError.textContent = "Name can be max 255 characters";
            isValid = false;
        }

        // Email validation
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(email === ""){
            emailError.textContent = "Email is required.";
            isValid = false;
        }else if (!email.match(emailPattern)) {
            emailError.textContent = "Please provide a valid email";
            isValid = false;
        }else if (email.length > 255) {
            emailError.textContent = "Email can be max 255 characters";
            isValid = false;
        }

        // Password validation
        if (password.length < 6) {
            passwordError.textContent = "Password must be at least 3 characters";
            isValid = false;
        }else if(password.length > 60) {
            passwordError.textContent = "Password can be max 60 characters";
            isValid = false;
        }else if (passwordConfirmation !== password) {
            passwordConfirmationError.textContent = "Passwords do not match";
            isValid = false;
        }

        if (isValid) {
            this.submit();
        }
    });
});