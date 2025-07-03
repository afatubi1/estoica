var tabla;
var horaActual;
var serial = 'NmY4NjdkYWJfXzIwMjQtMTAtMjRfXzIwMjQtMTItMjMjIyNUaTJwZ1VoamRkUEpsQ3VnTjM3MHB5SnhmdG5md3NFbDVLcCtSNEkzWm4rVWN4RS8wQU9HcG9QaHhiMWs2cWExL3hNRk94cFpuSk9nZXFnRi9JVThrU2VWMjlVMjc1WlRYcEFUTk1MRkRtMVJYaUFSamVPSTZ0VjFvRWhKQmlrQzJWQjhKbVAzMmVpSTIxUUhqY1hJaEFaYzN2UXF1bFRYZEFqS01rU3JIc0tlNnVmYjd2ekRXWVFqRjZXM2NMTXFBelRzd1FEOUZZNWdlYlNQaWJEL2w3aFcvN3U5QW5UVzRtMW1xWmgrSVgvZHhCalJrM1BxdWRkR3NjWjdxMm1KNi80ZTB6c3NKVUZDeDhBS3VNL1h4cm8vcVdYcGUwVVBGdWdvVy9Ib2ZqeU4xRUtWVFpHSnZLZXduOUU0dll4eEp0eng0QlRSUlZTbTQ0Q2pOTUpIWmpxUERTL2FCdkx5T00zYkZ5d1ROTGNyb2ErUWtjMEtRbGVjK1VGVTlXZHZsRlNLV2o2aC9VTjRxQ1dqZmNyQ3BNd3kwSFJEZ0d5R0tCY2tzWlRwNktKNHVsWHdJdHZxWVh6UWhBZmc2VGVqQ2RDUUdhUXpJWHg5MDBJTU9pdXlVNzRvNUhhUTdKUjBUYXpSZlg1aWtLd1owWTliNjdnZ2d4NDRLM2VzbFBxR0ZFY1FCSU9Sd0k4aU9iNUYrS3VTQ1hoanQ5bXFEYnNTbXZZRVZqN3ZOVWMvQ3dNZDNveGNEcUVuc0pLcXBCZjVtbE1QYmNhZCt5c0pmbk1MYmFvWEhTOUVmUFZNcllrdXl1cHVDdnFJL0hJZnQvaDNwV3ltMlY5YjFPZXhaWEpyeFNWOVQ4NnVOV01LMmVlRTU4WnNFMUhaLzB1SmJ4aDVKNTllNnB0R0hFaz0=';

function init() {
	getHours();
	setInterval(getHours, 30000);
	mostrarform(false);
	listar();
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
			"aProcessing": true,
			"aServerSide": true,
			dom: 'Bfrtip',
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
			"iDisplayLength": 50,
			"order": [[0, "desc"]]
		}).DataTable();
}

//Función para guardar
function guardaryeditar() {
	const imagen = $('#imagen').val();

	// Expresión regular para extensiones de imagen válidas
	const formatosPermitidos = /(\.jpg|\.jpeg|\.png|\.gif|\.jfif)$/i;
	if (!formatosPermitidos.test(imagen) ) {
		bootbox.alert('Formato de imagen no válido. Solo se permiten archivos JPG, JPEG, PNG, GIF o jfif.');
	} else if (validar()) {
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
	else {
		//bootbox.alert("Por favor, complete todos los campos obligatorios.");
	}
}

function validar() {
	const campos = [
		{ id: "fecha_hora", nombre: "Fecha" },
		{ id: "movimiento", nombre: "Movimiento" },
		{ id: "forma_pago", nombre: "Forma de pago" },
		{ id: "concepto", nombre: "Concepto clave" },
		{ id: "clave_l", nombre: "Clave" },
		{ id: "numeroCheque", nombre: "Folio del comprobante" },
		{ id: "idunidad", nombre: "Unidad" },
		{ id: "importe", nombre: "Importe" },
		{ id: "descripcion", nombre: "Descripción" },
		{ id: "plaza", nombre: "Plaza" },
		{ id: "imagen", nombre: "Imagen" }
	];

	// Array para almacenar los nombres de los campos vacíos
	const camposVacios = [];

	// Recorre cada campo y verifica si está vacío
	campos.forEach(campo => {
		const valor = document.getElementById(campo.id).value;
		if (!valor) {
			camposVacios.push(campo.nombre);
		}
	});

	// Si hay campos vacíos, muestra una alerta con la lista
	if (camposVacios.length > 0) {
		bootbox.alert("Por favor, complete los siguientes campos:\n- " + camposVacios.join("\n- "));
		return false; // Detiene el envío del formulario
	} else {
		return true;
	}
}

function mostrarImagen(url) {
	// Mostrar el modal
	$('#myModal').modal('show');

	// Mostrar spinner
	document.getElementById('load').style.display = 'block';

	// Asignar imágenes con fallback por defecto
	const img1 = document.getElementById('modalImage');
	const img2 = document.getElementById('modalImage2');

	const defaultImg = 'img/default.png'; // Ruta a imagen por defecto

	img1.style.display = 'none';

	img1.src = url && url.trim() !== '' ? url : defaultImg;

	// Cargar primera imagen
	img1.onload = function () {
		img1.style.display = 'block';
		checkBothLoaded();
	};
	img1.onerror = function () {
		img1.src = defaultImg;
		checkBothLoaded();
	};

	let loadedCount = 0;
	function checkBothLoaded() {
		loadedCount++;
		if (loadedCount === 2) {
			document.getElementById('load').style.display = 'none';
		}
	}
}

function openDoc(url){
	 if (url && typeof url === 'string') {
        window.open(url, '_blank');
    } else {
        alert('URL no válida');
    }
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

function print(idliquidacion) {
	var formData = new FormData();
	formData.append('idliquidacion', idliquidacion);
	$.ajax({
		url: "../ajax/liquidaciones.php?op=getLiquidacion",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			reprint(datos)

		}
	});
}

async function reprint(datos) {
	var datos = JSON.parse(datos);
	const nombreImpresora = "impre";
	const conector = new ConectorPluginV3(null, serial);
	const respuesta = await conector
		.Iniciar()
		.EstablecerAlineacion(ConectorPluginV3.ALINEACION_CENTRO)
		.EscribirTexto("\n\n")
		.EstablecerAlineacion(ConectorPluginV3.ALINEACION_IZQUIERDA)
		.EstablecerTamañoFuente(4, 4)
		.EstablecerTamañoFuente(1, 1)
		.EscribirTexto("Vendedor: " + datos.nombre + "\n")
		.EscribirTexto("Fecha: " + datos.fecha + "\n")
		.EscribirTexto("Hora: " + datos.hora + "\n")
		.EscribirTexto("Tipo pago movimiento: " + datos.movimiento + "\n")
		.EscribirTexto("plaza: " + datos.plaza + "\n")
		.EscribirTexto("Unidad: " + datos.clave + "\n")
		.EscribirTexto("Clave: " + datos.clave_l + "\n")
		.EscribirTexto("Folio externo: " + datos.numero_cheque + "\n")
		.EscribirTexto("Monto:  $" + datos.importe + ".00\n")
		.EscribirTexto("Folio descripcion: " + datos.descripcion + "\n")
		.Feed(1)
		.EstablecerAlineacion(ConectorPluginV3.ALINEACION_CENTRO)
		.Feed(1)
		.EstablecerTamañoFuente(2, 2)
		.EscribirTexto("TICKET EGRESOS - " + datos.movimiento.substring(0, 1) + "- 000" + datos.idliquidacion)
		.EscribirTexto("\n\n\n\n\n")
		.Feed(1)
		.CorteParcial()
		.imprimirEn(nombreImpresora);
	window.location.reload();
}

init();
