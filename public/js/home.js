document.addEventListener("DOMContentLoaded", function () {
    let topbar = document.querySelector(".topbar");
    let navbar = document.querySelector(".navbar");
    let lastScrollY = window.scrollY;
    let ticking = false;

    function updateNavbar() {
        if (window.scrollY > 50) {
            topbar.style.transform = "translateY(-100%)";
            navbar.style.top = "0";
            navbar.style.boxShadow = "0px 4px 10px rgba(0, 0, 0, 0.2)";
        } else {
            topbar.style.transform = "translateY(0)";
            navbar.style.top = "40px";
            navbar.style.boxShadow = "0px 4px 6px rgba(0, 0, 0, 0.1)";
        }
        ticking = false;
    }

    window.addEventListener("scroll", function () {
        lastScrollY = window.scrollY;
        if (!ticking) {
            requestAnimationFrame(updateNavbar);
            ticking = true;
        }
    });

    // Smooth Scroll for Back to Top button
    document.querySelector(".back-to-top").addEventListener("click", function (e) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
});