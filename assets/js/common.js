document.addEventListener("DOMContentLoaded", function () {

    //profile menu dropdown toggler
    const dropdownMenu = document.getElementById("dropdownMenu");
    const dropdownToggle = document.getElementById("dropdownToggle");
    dropdownToggle.addEventListener("click", function(event) {
        event.stopPropagation();
        dropdownMenu.classList.toggle("hidden");
    });
    document.addEventListener("click", function(event) {
        if (!dropdownMenu.contains(event.target) && !dropdownToggle.contains(event.target)) {
            dropdownMenu.classList.add("hidden");
        }
    });

    
    // badge close
    document.getElementById("successBadgeClose")?.addEventListener("click", function () {
        document.getElementById("successBadge").style.display = 'none';
    });
    document.getElementById("errorBadgeClose")?.addEventListener("click", function () {
        document.getElementById("errorBadge").style.display = 'none';
    });
});