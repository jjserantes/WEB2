var inputNombre = document.getElementById("Nombre");
var inputEmail = document.getElementById("Email");
var inputComentario = document.getElementById("Comentario");
var checkHola = document.getElementById("CheckHola");
var btnCrear = document.getElementById("btnCrear");

inputNombre.oninput = validacionInput;
inputEmail.oninput = validacionInput;
inputComentario.oninput = validacionInput;
checkHola.onchange = validacionInput;

function validacionInput(){
    if (inputNombre.value && inputEmail.value && inputComentario.value && checkHola.checked) {
        btnCrear.disabled = false;
    } else {
        btnCrear.disabled = true;
    }
}

