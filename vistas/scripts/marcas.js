var tabla;

// Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	listar();
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
		url: '../ajax/marcas.php?op=listar',
		type: 'GET',
		dataType: 'json',
		success: function(response) {     
			var tbody = $('#tbllistado tbody');
			tbody.empty(); // Limpiar el cuerpo de la tabla

			// Recorrer cada registro y añadirlo a la tabla
			for (var i = 0; i <response.length; i++) {
				var reg = response[i];
				var row = '<tr>' +
					'<td>' + reg.brand_name + '</td>' +
					'<td>' + reg.local_number + '</td>' +
					'<td>' + reg.horario + '</td>' +
					'<td>' + reg.information + '</td>' +
					'</tr>';
				tbody.append(row);
			}
		},
		error: function(xhr, status, error) {
			console.error('Error al listar las marcas:', error);
		}
	});
}


// Función para guardar o editar
$(document).ready(function () {
	$("#formulario").on("submit", function (e) {
		e.preventDefault(); // Previene la acción predeterminada del formulario

		var formData = new FormData(this);

		$.ajax({
			url: "../ajax/marcas.php?op=guardaryeditar",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function (datos) {
				bootbox.alert("Datos guardados: " + datos);
				limpiar();
				mostrarform(false);
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
