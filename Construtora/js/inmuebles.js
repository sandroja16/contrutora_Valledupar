// Función para realizar la petición AJAX y mostrar los inmuebles según los filtros seleccionados
function mostrarInmuebles() {
    // Crear la petición AJAX
    var xhr = new XMLHttpRequest();

    // Configurar la petición
    xhr.open('POST', 'inmuebles.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    // Configurar el evento onload para manejar la respuesta
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Obtener la respuesta del servidor
            var response = xhr.responseText;

            // Actualizar el contenedor de los inmuebles con la respuesta
            var contenedorInmuebles = document.getElementById('contenedor-inmuebles');
            contenedorInmuebles.innerHTML = response;
        } else {
            // Mostrar un mensaje de error en caso de fallo en la petición
            console.error('Error en la petición AJAX. Estado: ' + xhr.status);
        }
    };

    // Obtener los valores de los filtros
    var habitaciones = document.getElementById('habitaciones').value;
    var estrato = document.getElementById('estrato').value;
    var banos = document.getElementById('banos').value;

    // Armar el cuerpo de la petición con los filtros
    var params = 'habitaciones=' + encodeURIComponent(habitaciones) +
        '&estrato=' + encodeURIComponent(estrato) +
        '&banos=' + encodeURIComponent(banos);

    // Enviar la petición
    xhr.send(params);
}

// Llamar a la función para mostrar los inmuebles al cargar la página
window.addEventListener('load', mostrarInmuebles);
