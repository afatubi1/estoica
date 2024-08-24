var tabla;

// Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();
}
function setDate() {
    $("#fecha").datepicker({
        dateFormat: "yy-mm-dd"
    });
}
// Función limpiar
function limpiar() {
    $("#marca_nombre").val("");
    $("#local").val("");
    $("#Horario").val("");
    $("#Informacion").val("");
}

// Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnagregar").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").show(); // Asegúrate de que este botón exista en tu HTML
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
        $("#btnCancelar").hide(); // Es posible que también necesites ocultar este botón aquí
        $("#btnAgregarArt").hide(); // Es posible que también necesites ocultar este botón aquí
    }
}

// Función cancelar formulario
function cancelarform() {
    limpiar();
    mostrarform(false);
}

// Función Listar
function listar() {
    $.ajax({
        url: '../ajax/eventos.php?op=listar',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var tbody = $('#tbllistado tbody');
            tbody.empty(); // Limpiar el cuerpo de la tabla

            // Recorrer cada registro y añadirlo a la tabla
            for (var i = 0; i < response.length; i++) {
                var reg = response[i];
                var row = '<tr>' +
                    '<td><button class="btn btn-warning" onclick="mostrar(' + reg.idevento + ')"><li class="fa fa-pencil"></li></button></td>' +
                    '<td>' + reg.evento + '</td>' +
                    '<td>' + reg.fecha + '</td>' +
                    '<td>' + reg.hora + " hrs" + '</td>' +
                    '<td>' + reg.informacion + '</td>' +
                    '<td> event-00' + reg.idevento + '</td>' +
                    '</tr>';
                tbody.append(row);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error al listar los eventos:', error);
            console.error('Detalles:', xhr.responseText);
        }
    });
}

function mostrar(idevento) {
    $.post(
        "../ajax/eventos.php?op=getevento",
        { idevento: idevento },
        function (data, status) {
            var evento = JSON.parse(data); // Parsear la respuesta JSON
            mostrarform(true);
            $("#evento").val(evento.nombre);
            $("#fecha").val(evento.fecha);
            $("#hora").val(evento.hora);
            $("#informacion").val(evento.informacion);
            $("#idevento").val(evento.idevento);
        }
    );
}

// Función para guardar o editar
$(document).ready(function () {
    $("#formulario").on("submit", function (e) {
        e.preventDefault(); // Previene la acción predeterminada del formulario

        var formData = new FormData(this);

        $.ajax({
            url: "../ajax/eventos.php?op=guardaryeditar",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                bootbox.alert("Datos guardados: " + datos);
                limpiar();
                mostrarform(false);
                listar();
                // Si tienes una tabla, puedes recargarla aquí
                // tabla.ajax.reload();
            },
            error: function (xhr, status, error) {
                console.error("Error en la solicitud AJAX: ", error);
            }
        });
    });
});
init();
