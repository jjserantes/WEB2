document.addEventListener("DOMContentLoaded", function() {
    var imgUser = document.getElementById("imgUser");
    var userMenu = document.getElementById("userMenu");

    imgUser.addEventListener("click", function() {
        if (userMenu.style.display === "block") {
            userMenu.style.display = "none";
        } else {
            userMenu.style.display = "block";
        }
    });

    // Opcional: Cerrar el menú cuando se hace clic en cualquier parte fuera del menú
    document.addEventListener("click", function(event) {
        if (!imgUser.contains(event.target) && !userMenu.contains(event.target)) {
            userMenu.style.display = "none";
        }
    });
});
