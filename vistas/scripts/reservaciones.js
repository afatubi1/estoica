var tabla;
var horaActual;
var usuario;
var pagoEfectivo = false;
var serial = 'NmY4NjdkYWJfXzIwMjQtMTAtMjRfXzIwMjQtMTItMjMjIyNUaTJwZ1VoamRkUEpsQ3VnTjM3MHB5SnhmdG5md3NFbDVLcCtSNEkzWm4rVWN4RS8wQU9HcG9QaHhiMWs2cWExL3hNRk94cFpuSk9nZXFnRi9JVThrU2VWMjlVMjc1WlRYcEFUTk1MRkRtMVJYaUFSamVPSTZ0VjFvRWhKQmlrQzJWQjhKbVAzMmVpSTIxUUhqY1hJaEFaYzN2UXF1bFRYZEFqS01rU3JIc0tlNnVmYjd2ekRXWVFqRjZXM2NMTXFBelRzd1FEOUZZNWdlYlNQaWJEL2w3aFcvN3U5QW5UVzRtMW1xWmgrSVgvZHhCalJrM1BxdWRkR3NjWjdxMm1KNi80ZTB6c3NKVUZDeDhBS3VNL1h4cm8vcVdYcGUwVVBGdWdvVy9Ib2ZqeU4xRUtWVFpHSnZLZXduOUU0dll4eEp0eng0QlRSUlZTbTQ0Q2pOTUpIWmpxUERTL2FCdkx5T00zYkZ5d1ROTGNyb2ErUWtjMEtRbGVjK1VGVTlXZHZsRlNLV2o2aC9VTjRxQ1dqZmNyQ3BNd3kwSFJEZ0d5R0tCY2tzWlRwNktKNHVsWHdJdHZxWVh6UWhBZmc2VGVqQ2RDUUdhUXpJWHg5MDBJTU9pdXlVNzRvNUhhUTdKUjBUYXpSZlg1aWtLd1owWTliNjdnZ2d4NDRLM2VzbFBxR0ZFY1FCSU9Sd0k4aU9iNUYrS3VTQ1hoanQ5bXFEYnNTbXZZRVZqN3ZOVWMvQ3dNZDNveGNEcUVuc0pLcXBCZjVtbE1QYmNhZCt5c0pmbk1MYmFvWEhTOUVmUFZNcllrdXl1cHVDdnFJL0hJZnQvaDNwV3ltMlY5YjFPZXhaWEpyeFNWOVQ4NnVOV01LMmVlRTU4WnNFMUhaLzB1SmJ4aDVKNTllNnB0R0hFaz0=';
//Función que se ejecuta al inicio
function init() {
	getHours();
	setInterval(getHours, 30000);
	mostrarform(false);
	listar();
	getUsuario();
	getFolioReserva();
	$("#efectivo").val("0");

	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
		if (pagoEfectivo) {
			guardarVentaEfectivo(e)
		}
	});

	$.post("../ajax/ventaDos.php?op=selectUnidad", function (r) {
		$("#idunidad").html(r);
		$('#idunidad').selectpicker('refresh');
	});

	$.post("../ajax/reservaciones.php?op=getIdVentaEfectivo", function (r) {
		$("#idefectivo").val(r);
	});
}

function getIdEfectivo() {
	$.post("../ajax/reservaciones.php?op=getIdVentaEfectivo", function (r) {
		$("#idefectivo").val(r);
	});
}

function getFolioReserva() {
	$.post("../ajax/reservaciones.php?op=getFolioReserva", function (r) {
		$("#getFolioReserva").val(r);
	});
}

//Función limpiar
function limpiar() {
	$("#idcliente").val("");
	$("#cliente").val("");
	$("#serie_comprobante").val("");
	$("#total_mxn").val("");
	$("#total_usd").val("0");

	$("#total_venta").val("");
	$(".filas").remove();
	$("#total").html("0");

	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear() + "-" + (month) + "-" + (day);
	$('#fecha').val(today);

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
				url: '../ajax/reservaciones.php?op=listar',
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
	fillTicket();
	var formData = new FormData($("#formulario")[0]);


	for (var i = 0; i < 3; i++) {
		imprimir();
	}
	$.ajax({
		url: "../ajax/reservaciones.php?op=guardar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {
			bootbox.alert(datos);
			mostrarform(false);
			getIdEfectivo();
		}

	});
	limpiar();
}

//Funcion guardar id venta efectivo
function guardarVentaEfectivo(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	fillTicket();
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../ajax/reservaciones.php?op=guardarIdEfectivo",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {
			listar();
		}

	});
	limpiar();
}

function fillTicket() {
	$('#unidad_save').val(fillUnidad());
	$('#chofer_save').val(fillChofer());
	$('#auto_save').val(fillAuto());
	$('#hour_save').val(document.getElementById("hora").value);
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

function fillChofer() {
	var selectElement = document.getElementById("idConductor");
	// Obtener el valor seleccionado
	var selectedValue = selectElement.value;
	// Obtener todos los valores en el elemento "select"
	var options = selectElement.options;
	var values = [];
	var chofer
	for (var i = 0; i < options.length; i++) {
		values.push(options[i].text);
		if (options[i].value == selectedValue) {
			chofer = options[i].text
		}
	}
	return chofer;
}

function fillAuto() {
	var selectElement = document.getElementById("auto");
	var selectedValue = selectElement.value;
	var options = selectElement.options;
	var values = [];
	var auto
	for (var i = 0; i < options.length; i++) {
		values.push(options[i].text);
		if (options[i].value == selectedValue) {
			auto = options[i].text
		}
	}
	return auto;
}

async function imprimir() {
	var totalUsd = document.getElementById("total_usd").value;
	var Conductor = document.getElementById("chofer_save").value;
	var Fecha = document.getElementById("fecha").value;
	var Hora = document.getElementById("hora").value;
	var viaje = document.getElementById("tipo_viaje").value;
	var Destino = document.getElementById("destino_save").value;
	var Kilometros = document.getElementById("kilometro").value;
	var Pasajeros = document.getElementById("numero_pasajero").value;
	var Unidad = document.getElementById("unidad_save").value;
	var Auto = document.getElementById("auto_save").value;
	var tipoPago = document.getElementById("tipo_pago").value;
	var numeroTicket = document.getElementById("ticket_num").value;
	var folioReservacion = parseInt(document.getElementById("getFolioReserva").value) + 1;
	var totalMxn = document.getElementById("total_mxn").value;
	var totalUsd = document.getElementById("total_usd").value;
	var numero_celular = document.getElementById("numero_celular").value;
	var nombre_cliente = document.getElementById("nombre_cliente").value;

	var efectivo
	if (parseInt(document.getElementById("efectivo").value) == "") {
		efectivo = "0";

	} else {
		efectivo = document.getElementById("efectivo").value;
	}


	const nombreImpresora = "impresora";
	const conector = new ConectorPluginV3(null, serial);
	const respuesta = await conector
		.Iniciar()
		.EstablecerAlineacion(ConectorPluginV3.ALINEACION_CENTRO)
		.EscribirTexto("\n\n")
		.EstablecerAlineacion(ConectorPluginV3.ALINEACION_IZQUIERDA)
		.EstablecerTamañoFuente(4, 4)
		.EstablecerTamañoFuente(1, 1)
		.EscribirTexto("Vendedor: " + usuario + "\n")
		.EscribirTexto("Conductor: " + Conductor + "\n")
		.EscribirTexto("Nombre del cliente: " + nombre_cliente + "\n")
		.EscribirTexto("Numero celular: " + numero_celular + "\n")
		.EscribirTexto("Fecha: " + Fecha + "\n")
		.EscribirTexto("Hora: " + Hora + "\n")
		.EscribirTexto("Tipo de viaje: " + viaje + "\n")
		.EscribirTexto("Destino: " + Destino + "\n")
		.EscribirTexto("Kilometros: " + Kilometros + "\n")
		.EscribirTexto("Pasajeros: " + Pasajeros + "\n")
		.EscribirTexto("Unidad: " + Unidad + "\n")
		.EscribirTexto("Auto: " + Auto + "\n")
		.EscribirTexto("Tipo de pago: " + tipoPago + "\n")
		.EscribirTexto("Numero de ticket: " + numeroTicket + "\n")
		.EscribirTexto("Folio Reservacion: " + folioReservacion + "\n")
		.EscribirTexto("Total MXN: $" + totalMxn + ".00" + "\n")
		.EscribirTexto("Total USD: $" + totalUsd + ".00" + "\n")
		.EscribirTexto("Efectivo: $" + efectivo + ".00" + "\n")
		.Feed(1)
		.EstablecerAlineacion(ConectorPluginV3.ALINEACION_CENTRO)
		.EscribirTexto("Su destino incluye maximo el pago de un peaje.\n Las casetas exentas de pago son Segundo Piso de Periferico, Arco Norte, Chamapa la Venta y Siervo de la Nacion. Si deseas que tu ruta pase por alguna de estas casetas el pago sera absorbido por el cliente.\n\n")
		.EscribirTexto("Facturas:   grupotaxal2022@gmail.com\n")
		.EscribirTexto("Recoleccion y Reservaciones : +52 5634342175\n\n")
		.Feed(1)
		.EstablecerTamañoFuente(2, 2)
		.EscribirTexto("TICKET DE VENTA")
		.EscribirTexto("\n\n\n\n\n")
		.Feed(1)
		.CorteParcial()
		.imprimirEn(nombreImpresora);
}

$('#tipo_pago').on('change', function (e) {
	if (this.value,
		this.options[this.selectedIndex].value,
		$(this).find("option:selected").val() == "Efectivo") {
		var idefectivo = parseInt(document.getElementById("idefectivo").value) + 1;
		$("#ticket_num").val("EFEC-00" + idefectivo)
		$("#folioVentaEfectivo").val("EFEC-00" + idefectivo);
		pagoEfectivo = true;
	} else {
		$("#ticket_num").val("")
		pagoEfectivo = false;
	}
});

var idventarfc;
var cfdi;
var facturaPdf;
var qr;
var folioFactura;
var dateRfc;

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

function editarMontos(idreservaciones, facturado) {
	if (facturado == "1") {
		getMontos(idreservaciones)
	} else {
		bootbox.alert("Reservacion cerrada, no se puede editar");
	}
}

// update reserva
function updateReserva() {
	var formData = new FormData($("#formRfc")[0]);
	$.ajax({
		url: "../ajax/reservaciones.php?op=updateReserva",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (data) {
		},
		error: function (XMLHttpRequest, textStatus, errorThrown) {
		}
	});
}

function getUsuario() {
	$.ajax({
		url: "../ajax/corte.php?op=getUsuario",
		type: "POST",
		contentType: false,
		processData: false,

		success: function (datos) {
			usuario = datos;
		}
	});
}


function print(idreservaciones) {
	var formData = new FormData();
	formData.append('idreservaciones', idreservaciones);
	$.ajax({
		url: "../ajax/reservaciones.php?op=getReservaciones",
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
	const nombreImpresora = "impresora";
	const conector = new ConectorPluginV3(null, serial);
	const respuesta = await conector
		.Iniciar()
		.EstablecerAlineacion(ConectorPluginV3.ALINEACION_CENTRO)
		.EscribirTexto("\n\n")
		.EstablecerAlineacion(ConectorPluginV3.ALINEACION_IZQUIERDA)
		.EstablecerTamañoFuente(4, 4)
		.EstablecerTamañoFuente(1, 1)
		.EscribirTexto("Vendedor: " + datos.nombre + "\n")
		.EscribirTexto("Conductor: " + datos.idConductor + "\n")
		.EscribirTexto("Nombre del cliente: " + datos.nombre_cliente + "\n")
		.EscribirTexto("Numero celular: " + datos.numero_celular + "\n")
		.EscribirTexto("Fecha: " + datos.fecha + "\n")
		.EscribirTexto("Hora: " + datos.hora + "\n")
		.EscribirTexto("Tipo de viaje: " + datos.tipo_viaje + "\n")
		.EscribirTexto("Destino: " + datos.idruta + "\n")
		.EscribirTexto("Kilometros: " + datos.kilometro + "\n")
		.EscribirTexto("Pasajeros: " + datos.numero_pasajero + "\n")
		.EscribirTexto("Unidad: " + datos.clave + "\n")
		.EscribirTexto("Auto: " + datos.automovil + "\n")
		.EscribirTexto("Tipo de pago: " + datos.tipo_pago + "\n")
		.EscribirTexto("Numero de ticket: " + datos.ticket_num + "\n")
		.EscribirTexto("Folio Reservacion: " + datos.idreservaciones + "\n")
		.EscribirTexto("Efectivo: $" + datos.efectivo + ".00" + "\n")
		.EscribirTexto("Tarjeta: $" + datos.tarjeta + ".00" + "\n")
		.EscribirTexto("Dolar: $" + datos.dolar + ".00" + "\n")
		.EscribirTexto("CXC: $" + datos.cxc + ".00" + "\n")
		.Feed(1)
		.EstablecerAlineacion(ConectorPluginV3.ALINEACION_CENTRO)
		.EscribirTexto("Su destino incluye maximo el pago de un peaje.\n no aplica en casetas del Segundo Piso de Periferico, Arco Norte, Chamapa la Venta y Siervo de la Nacion. Si deseas que tu ruta pase por alguna de estas casetas el pago sera absorbido por el cliente.\n\n")
		.EscribirTexto("Solo se emiten facturas después de  10 días del servicio y solo dentro del mes correspondiente\n")
		.EscribirTexto("Facturas:   estoicadrive@gmail.com\n")
		.EscribirTexto("Recoleccion y Reservaciones : +52 5536704952\n\n")
		.Feed(1)
		.EstablecerTamañoFuente(2, 2)
		.EscribirTexto("TICKET DE RESERVACION - " + datos.tipo_pago.substring(0, 1) + datos.idreservaciones)
		.EscribirTexto("\n\n\n\n\n")
		.Feed(1)
		.CorteParcial()
		.imprimirEn(nombreImpresora);
}

function updateMontos() {
	const tarjeta_edit = $('#tarjeta_edit').val();
	const efectivo_edit = $('#efectivo_edit').val();
	const dolar_edit = $('#dolar_edit').val();
	const cxc_edit = $('#cxc_edit').val();
	const idreservaciones_edit = $('#idreservaciones_edit').val();

	$.ajax({
		url: '../ajax/reservaciones.php?op=updateMontos', // Cambia esta URL a la ruta de tu backend
		type: 'POST',
		data: {
			tarjeta_edit: tarjeta_edit,
			efectivo_edit: efectivo_edit,
			dolar_edit: dolar_edit,
			cxc_edit: cxc_edit,
			idreservaciones_edit: idreservaciones_edit
		},
		success: function (response) {
			console.log("Exito al actualizar montos");
			window.location.reload();
		},
		error: function (xhr, status, error) {
			console.error('Error:', error);
		}
	});

}

function getMontos(idreservaciones) {
	$.ajax({
		url: '../ajax/reservaciones.php?op=getMontos',
		type: 'POST',
		data: { idreservaciones: idreservaciones },
		dataType: 'json',
		success: function (response) {
			function setInputValue(selector, value) {
				$(selector).val(value === "" ? "0" : value);
			}

			setInputValue('#efectivo_edit', response.efectivo);
			setInputValue('#tarjeta_edit', response.tarjeta);
			setInputValue('#dolar_edit', response.dolar);
			setInputValue('#cxc_edit', response.cxc);
			$("#idreservaciones_edit").val(idreservaciones);
			$("#myModal").modal();
		},
		error: function (xhr, status, error) {
			console.error('Error en la petición AJAX:', error);
		}
	});
}

function abrirmodal(idreservaciones, facturado) {
	if (facturado == "1") {
		$("#idreservaciones_edit").val(idreservaciones);
		$("#modalConfirm").modal();
	} else {
		bootbox.alert("Reservacion cerrada, no se puede cerar otra vez");
	}

}


function cerrarReserva() {
	$('#modalConfirm').modal('hide');
	var idreservaciones = document.getElementById("idreservaciones_edit").value;
	$.ajax({
		url: '../ajax/reservaciones.php?op=updateReserva',
		type: 'POST',
		data: {
			idreservaciones: idreservaciones
		},
		success: function (response) {
			console.log("Exito al cerrar reserva");
			getDataSales(idreservaciones)
		},
		error: function (xhr, status, error) {
			// Manejar errores
			console.error('Error:', error);
		}
	});
}

function getDataSales(idreservaciones) {
	$.ajax({
		url: '../ajax/reservaciones.php?op=getMontos',
		type: 'POST',
		data: { idreservaciones: idreservaciones },
		dataType: 'json',
		success: function (response) {
			saveSale(response)
		},
		error: function (xhr, status, error) {
			console.error('Error en la petición AJAX:', error);
		}
	});
}

function isEmpty(value){
	if(value == ""){
		return 0;
	}else{
		return value;
	}
}


function saveSale(response) {
	var total = parseFloat(isEmpty(response.efectivo)) + parseFloat(isEmpty(response.cxc)) + parseFloat(isEmpty(response.tarjeta));
	const idusuario = response.idusuario;
	const auto = response.automovil;
	const pasajero = response.numero_pasajero;
	const tarjeta = response.tarjeta;
	const fecha_hora = response.fecha;
	const hora = response.hora;
	const dolar = response.dolar;
	const total_venta = total;
	const ruta = response.idruta;
	const unidad = response.idunidad;
	const tipo_pago = response.tipo_pago;
	const ticket_num = response.ticket_num;
	const efectivo = response.efectivo;
	const cxc = response.cxc;
	const kilometro = response.kilometro;

	$.ajax({
		url: '../ajax/ventaDos.php?op=guardaryeditar',
		type: 'POST',
		data: {
			idusuario: idusuario,
			auto: auto,
			Pasajero: pasajero,
			Tarjeta: tarjeta,
			fecha_hora: fecha_hora,
			hour_save: hora,
			Dolar: dolar,
			total_venta: total_venta,
			idrutas: ruta,
			idunidad: unidad,
			tipo_pago: tipo_pago,
			ticket_num: ticket_num,
			Efectivo: efectivo,
			CXC: cxc,
			kilometro: kilometro
		},
		dataType: 'json',
		success: function (response) {
			bootbox.alert("Venta registrada numero de ESTOI - 00" + response);
			listar();
		},
		error: function (xhr, status, error) {
			console.error('Error en la petición AJAX:', error);
		}
	});
}
init();
