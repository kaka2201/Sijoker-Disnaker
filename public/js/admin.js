function toggleSidebar() {
    let sidebar = document.getElementById("sidebar");
    let content = document.getElementById("content");
    sidebar.classList.toggle("closed");
    content.classList.toggle("shift");
    // Tutup dropdown jika sidebar ditutup
    if (sidebar.classList.contains("closed")) {
        document.querySelectorAll(".dropdown").forEach(dropdown => {
            dropdown.classList.remove("active");
            dropdown.querySelector(".dropdown-menu").classList.remove("show");
        });
    }
}

document.addEventListener("DOMContentLoaded", function () {
    let complaintMenu = document.querySelector(".complaint-menu");

    complaintMenu.addEventListener("click", function (event) {
        event.preventDefault();
    
        let dropdown = complaintMenu.parentElement;
        let dropdownMenu = dropdown.querySelector(".dropdown-menu");
    
        dropdown.classList.toggle("active");
        dropdownMenu.classList.toggle("show");
    });

    // Klik di luar dropdown untuk menutupnya
    document.addEventListener("click", function (event) {
        if (!complaintMenu.contains(event.target) && !dropdownMenu.contains(event.target)) {
            let activeDropdown = document.querySelector(".dropdown.active");
            if (activeDropdown) {
                activeDropdown.classList.remove("active");
                activeDropdown.querySelector(".dropdown-menu").classList.remove("show");
            }
        }
    });
});