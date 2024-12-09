document.addEventListener('DOMContentLoaded', function() {
    const list = document.getElementById('full-width-nav');

    window.addEventListener("resize", function () {
        if (window.innerWidth > 900) {
            list.style.display = "flex";
        } else {
            list.style.display = "none";
        }
    });
     
});

document.getElementById('hamburger').addEventListener("click", function () {
    const list = document.getElementById('full-width-nav');
    const isOpen = list.style.display === "block";

    list.style.display = isOpen ? "none" : "block";
});

document.addEventListener("click", function (event) {
    const list = document.getElementById('full-width-nav');
    const isClickInsideMenu = list.contains(event.target) || hamburger.contains(event.target);

    if (!isClickInsideMenu && window.innerWidth <= 900) {
        list.style.display = "none";
    }
});

