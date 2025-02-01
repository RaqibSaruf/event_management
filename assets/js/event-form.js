document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("eventCreateForm").addEventListener("submit", function (event) {
        event.preventDefault();
        let isValid = true;

        // Get field values
        const name = document.getElementById("name").value.trim();
        const description = document.getElementById("description").value.trim();
        const maxCapacity = document.getElementById("max_capacity").value.trim();
        const startTime = document.getElementById("start_time").value;
        const endTime = document.getElementById("end_time").value;

        // Get error elements
        const nameError = document.getElementById("nameError");
        const descriptionError = document.getElementById("descriptionError");
        const maxCapacityError = document.getElementById("maxCapacityError");
        const startTimeError = document.getElementById("startTimeError");
        const endTimeError = document.getElementById("endTimeError");

        // Reset error messages
        nameError.textContent = "";
        descriptionError.textContent = "";
        maxCapacityError.textContent = "";
        startTimeError.textContent = "";
        endTimeError.textContent = "";

        // Name validation
        if (name.length < 3) {
            nameError.textContent = "Name must be at least 3 characters";
            isValid = false;
        }

        // Description validation
        if (description.length < 60) {
            descriptionError.textContent = "Description must be at least 60 characters";
            isValid = false;
        }

        // Max Capacity validation
        if (!/^\d+$/.test(maxCapacity) || parseInt(maxCapacity) < 1) {
            maxCapacityError.textContent = "Must be a valid positive integer";
            isValid = false;
        }

        // Start Time validation
        if (startTime === "") {
            startTimeError.textContent = "Start time is required";
            isValid = false;
        }

        // End Time validation
        if (endTime === "") {
            endTimeError.textContent = "End time is required";
            isValid = false;
        } else if (new Date(endTime) < new Date(startTime)) {
            endTimeError.textContent = "End time must be after start time";
            isValid = false;
        }

        if (isValid) {
            this.submit();
        }
    });
});
