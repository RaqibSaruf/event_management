document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("loginForm").addEventListener("submit", function (event) {
        event.preventDefault();

        let isValid = true;

        // Get field values
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value.trim();

        // Get error elements
        const emailError = document.getElementById("emailError");
        const passwordError = document.getElementById("passwordError");

        // Reset error messages
        emailError.textContent = "";
        passwordError.textContent = "";

        // Email validation
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(email === ""){
            emailError.textContent = "Email is required.";
            isValid = false;
        }else if (!email.match(emailPattern)) {
            emailError.textContent = "Please provide a valid email";
            isValid = false;
        }

        // Password validation
        if (password === "") {
            passwordError.textContent = "Password is required";
            isValid = false;
        }

        if (isValid) {
            this.submit();
        }
    });
});