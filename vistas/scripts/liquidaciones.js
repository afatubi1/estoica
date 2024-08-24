var tabla;
var horaActual;

function init() {
	getHours();
	setInterval(getHours, 30000);
	mostrarform(false);
	listar();

	$("#formLiquidacion").on("submit", function (e) {
		guardaryeditar(e);
	});
	//Cargamos los items al select proveedor
	$.post("../ajax/venta.php?op=selectUnidad", function (r) {
		$("#idunidad").html(r);
		$('#idunidad').selectpicker('refresh');
	});

}

//Función limpiar
function limpiar() {

	$("#clave").val("");
	$("#concepto").val("");
	$("#numeroCheque").val("");
	$("#idunidad").val("");
	$("#importe").val("");
	$("#descripcion").val("");
	$("#fecha_hora").val("");

	
	$(".filas").remove();

	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear() + "-" + (month) + "-" + (day);
	$('#fecha_hora').val(today);

	//Marcamos el primer tipo_documento
	$("#auto").val("Boleta");
	$("#auto").selectpicker('refresh');
}

//Función mostrar formulario
function mostrarform(flag) {
	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnagregar").hide();

		$("#btnCancelar").show();
		$("#btnAgregarArt").show();
	}
	else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform() {
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar() {
	tabla = $('#tbllistado').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [
				'copyHtml5',
				'excelHtml5',
				'csvHtml5',
				'pdf'
			],
			"ajax":
			{
				url: '../ajax/liquidaciones.php?op=listar',
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 50,//Paginación
			"order": [[0, "desc"]]//Ordenar (columna,orden)
		}).DataTable();
}

//Función para guardar
function guardaryeditar(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formLiquidacion")[0]);
	$.ajax({
		url: "../ajax/liquidaciones.php?op=guardar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {
			bootbox.alert(datos);
			mostrarform(false);
			listar();
		}

	});
	limpiar();
}


function fillUnidad() {
	var selectElement = document.getElementById("idunidad");
	// Obtener el valor seleccionado
	var selectedValue = selectElement.value;
	// Obtener todos los valores en el elemento "select"
	var options = selectElement.options;
	var values = [];
	var unidad
	for (var i = 0; i < options.length; i++) {
		values.push(options[i].text);
		if (options[i].value == selectedValue) {
			unidad = options[i].text
		}
	}
	return unidad;
}


function getFechaLocal() {
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear() + "-" + (month) + "-" + (day);
	return today;
}

function getHours() {
	var d = new Date();
	var h = ("0" + d.getHours()).slice(-2);
	var m = ("0" + d.getMinutes()).slice(-2);
	var s = ("0" + d.getSeconds()).slice(-2);
	var time = h + ":" + m + ":" + s;

	$('#hour_save').val(time);
	horaActual = time;
}

init();
