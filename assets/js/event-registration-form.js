document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("eventRegistrationForm").addEventListener("submit", function (event) {
        event.preventDefault();
        let isValid = true;

        // Get field values
        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();

        // Get error elements
        const nameError = document.getElementById("nameError");
        const emailError = document.getElementById("emailError");

        // Reset error messages
        nameError.textContent = "";
        emailError.textContent = "";

        // Name validation
        if (name.length < 3) {
            nameError.textContent = "Name must be at least 3 characters";
            isValid = false;
        } else if (name.length > 255) {
            nameError.textContent = "Name can be max 255 characters";
            isValid = false;
        }

        // Email validation
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(email === ""){
            emailError.textContent = "Email is required.";
            isValid = false;
        } else if (!email.match(emailPattern)) {
            emailError.textContent = "Please provide a valid email";
            isValid = false;
        } else if (email.length > 255) {
            emailError.textContent = "Email can be max 255 characters";
            isValid = false;
        }

        if (isValid) {
            this.submit();
        }
    });
});
