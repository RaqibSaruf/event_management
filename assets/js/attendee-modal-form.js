function onModalOpen(eventId, eventName) {
    document.getElementById("name").value = "";
    document.getElementById("email").value = "";
    document.getElementById("eventId").value = eventId;
    document.getElementById("modalEventName").textContent = eventName;
    document.getElementById("eventModal").classList.remove("hidden");
}
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("eventModal");
    const closeModal = document.getElementById("closeModal");
    const closeModalBtn = document.getElementById("closeModalBtn");

    function closModalWithReset(){
        modal.classList.add("hidden");
        document.getElementById("name").value = "";
        document.getElementById("email").value = "";
        document.getElementById("eventId").value = "";
        document.getElementById("modalEventName").textContent="";
        document.getElementById("nameError").textContent = "";
        document.getElementById("emailError").textContent = "";
    }

    closeModal.addEventListener("click", () => {
        closModalWithReset()
    });

    closeModalBtn.addEventListener("click", () => {
        closModalWithReset()
    });

    document.getElementById("eventRegistrationForm").addEventListener("submit", async function (event) {
        event.preventDefault();
        let isValid = true;

        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();
        const eventId = document.getElementById("eventId").value.trim();
        const nameError = document.getElementById("nameError");
        const emailError = document.getElementById("emailError");

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
            const eventRegistrationSubmitBtn = document.getElementById("eventRegistrationSubmitBtn");
            eventRegistrationSubmitBtn.disabled = true;
            const btnLoading = document.getElementById("btnLoading");
            btnLoading.classList.remove("hidden");
            const response = await fetch(`${baseUrl}${`/api/events/${eventId}/attendees` }`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                })
            });
            const result = await response.json();

            if(result?.statusCode !== 201){
                nameError.textContent = result?.errors?.name ?? '';
                emailError.textContent = result?.errors?.email ?? '';
            } else {
                document.getElementById("modalMsg").textContent = "(" + result?.message + ")";
                setTimeout(() => {
                    closModalWithReset();
                    document.getElementById("modalMsg").textContent = "";
                }, 2000);
            }

            eventRegistrationSubmitBtn.disabled = false;
            btnLoading.classList.add("hidden");
        }
    });
});