/*document.addEventListener("DOMContentLoaded", function() {
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

    // Funcionalidad para el desplegable de 'asidemovil' en modo responsive
    const asidemovil = document.querySelector('.asidemovil');
    const ul = asidemovil.querySelector('ul');

    asidemovil.addEventListener('click', function() {
        if (ul.style.display === 'block') {
            ul.style.display = 'none';
        } else {
            ul.style.display = 'block';
        }
    });
});

var papeleras=document.getElementsByClassName("fa-trash")

for (let index=0;index < papeleras.length;index++){
    const element = papeleras[index];
    element.onclick=function(e){
        if (confirm("¿Estás seguro de que quieres eliminar este elemento?")) {
       var row=this.closest('tr');
       row.remove();
    };
};
}*/
// Esperar a que todo el contenido de la página esté completamente cargado
document.addEventListener("DOMContentLoaded", function() {
    // Obtener los elementos por sus ID's
    var imgUser = document.getElementById("imgUser");
    var userMenu = document.getElementById("userMenu");

    // Añadir evento de clic para el elemento imgUser
    imgUser.addEventListener("click", function() {
        // Alternar la visibilidad del menú de usuario
        if (userMenu.style.display === "block") {
            userMenu.style.display = "none";
        } else {
            userMenu.style.display = "block";
        }
    });

    // Cerrar el menú cuando se hace clic fuera del menú
    document.addEventListener("click", function(event) {
        if (!imgUser.contains(event.target) && !userMenu.contains(event.target)) {
            userMenu.style.display = "none";
        }
    });

    // Obtener y configurar la funcionalidad para el elemento asidemovil
    const asidemovil = document.querySelector('.asidemovil');
    const ul = asidemovil.querySelector('ul');

    asidemovil.addEventListener('click', function() {
        // Alternar la visibilidad del menú desplegable
        if (ul.style.display === 'block') {
            ul.style.display = 'none';
        } else {
            ul.style.display = 'block';
        }
    });

    // Obtener el formulario y el cuerpo de la tabla
    const form = document.querySelector('.incidencias form');
    const tableBody = document.querySelector('tbody');
    let editMode = false; // Variable para seguir el modo de edición
    let editRow = null; // Fila actualmente en edición

    // Añadir evento de envío al formulario
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir el comportamiento predeterminado de envío

        // Obtener los valores de los campos del formulario
        const fecha = document.getElementById('fecha').value;
        const descripcion = document.getElementById('descripcion').value;

        // Formatear la fecha de yyyy-mm-dd a dd/mm/yyyy
        const [anio, mes, dia] = fecha.split("-");
        const fechaFormateada = `${dia}/${mes}/${anio}`;

        if (editMode && editRow) {
            // Si estamos en modo de edición, actualizar la fila existente
            editRow.querySelector('td:nth-child(2)').textContent = fechaFormateada;
            editRow.querySelector('td:nth-child(3)').textContent = descripcion;
            editMode = false; // Salir del modo de edición
            editRow = null; // Limpiar la fila en edición
        } else {
            // Si no estamos en modo de edición, agregar una nueva fila
            const newRow = document.createElement('tr');
            const newId = tableBody.getElementsByTagName('tr').length + 1; // Calcular nuevo ID

            // Crear el contenido de la nueva fila
            newRow.innerHTML = `
                <td>${newId}</td>
                <td>${fechaFormateada}</td>
                <td>${descripcion}</td>
                <td>
                    <i class="fa-solid fa-trash"></i>
                    <i class="fa-solid fa-edit"></i>
                </td>
            `;

            // Añadir la nueva fila al cuerpo de la tabla
            tableBody.appendChild(newRow);

            // Añadir evento de clic a las nuevas papeleras y botones de edición
            newRow.querySelector('.fa-trash').addEventListener('click', function() {
                if (confirm("¿Estás seguro de que quieres eliminar este elemento?")) {
                    this.closest('tr').remove();
                    actualizarIDs(); // Actualizar los IDs después de eliminar
                }
            });

            newRow.querySelector('.fa-edit').addEventListener('click', function() {
                editRow = this.closest('tr'); // Establecer la fila en edición
                // Rellenar los campos del formulario con los valores de la fila
                document.getElementById('fecha').value = editRow.querySelector('td:nth-child(2)').textContent.split('/').reverse().join('-');
                document.getElementById('descripcion').value = editRow.querySelector('td:nth-child(3)').textContent;
                editMode = true; // Entrar en modo de edición
            });
        }

        form.reset(); // Limpiar los campos del formulario
    });

    // Asignar evento de clic a las papeleras y botones de edición existentes en la tabla
    document.querySelectorAll('.fa-trash').forEach(function(element) {
        element.addEventListener('click', function() {
            if (confirm("¿Estás seguro de que quieres eliminar este elemento?")) {
                this.closest('tr').remove();
                actualizarIDs(); // Actualizar los IDs después de eliminar
            }
        });
    });

    document.querySelectorAll('.fa-edit').forEach(function(element) {
        element.addEventListener('click', function() {
            editRow = this.closest('tr'); // Establecer la fila en edición
            // Rellenar los campos del formulario con los valores de la fila
            document.getElementById('fecha').value = editRow.querySelector('td:nth-child(2)').textContent.split('/').reverse().join('-');
            document.getElementById('descripcion').value = editRow.querySelector('td:nth-child(3)').textContent;
            editMode = true; // Entrar en modo de edición
        });
    });

    // Obtener el elemento del input de fecha
    const fechaInput = document.getElementById("fecha");

    // Función para obtener la fecha actual en formato dd/mm/yyyy
    function obtenerFechaActual() {
        const hoy = new Date();
        const dia = String(hoy.getDate()).padStart(2, '0');
        const mes = String(hoy.getMonth() + 1).padStart(2, '0'); // Los meses van de 0-11
        const anio = hoy.getFullYear();
        return `${dia}/${mes}/${anio}`;
    }

    // Establecer la fecha actual en el input de fecha
    fechaInput.value = obtenerFechaActual().split("/").reverse().join("-");

    // Función para actualizar los IDs de las filas de la tabla
    function actualizarIDs() {
        document.querySelectorAll('tbody tr').forEach((row, index) => {
            row.querySelector('td:first-child').textContent = index + 1;
        });
    }
});
