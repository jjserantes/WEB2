var formulario = document.getElementById("formulario");
formulario.onsubmit = function(e) {
    e.preventDefault();
    var usuario = document.getElementById("usuario").value;
    var password = document.getElementById("password").value;
    if (usuario == "admin" && password == "admin") {
        window.location.href = "index.html";
    } else {
        alert("Usuario o contraseña incorrectos. Por favor, inténtalo de nuevo.");
    }
};
