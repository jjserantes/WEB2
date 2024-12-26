
var inputPass = document.getElementById("password");
var inputRePass = document.getElementById("repassword");
var btnCrear = document.getElementById("btnCrear");

inputPass.oninput = validacionInput;
inputRePass.oninput = validacionInput;

function validacionInput(){
        var txtPass = inputPass.value;
        var txtRePass = inputRePass.value;
        if(txtPass==txtRePass){
        btnCrear.disabled=false;
        } else{
            btnCrear.disabled=true;
        }
}