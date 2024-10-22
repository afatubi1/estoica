var tabla;
var horaActual;
var usuario;
var pagoEfectivo = false;
var serial = 'NmY4NjdkYWJfXzIwMjQtMDgtMjJfXzIwMjQtMTAtMjEjIyNhbXZ1T0ExeG9IaUx5WHFlZDlhQzB6Q0tLN2lxa3ZxV0FsU1ErZmI3TXZVSDcvNG1oR2ZYVmkyc2NXeFdIRDNYZEo1TE9IeUNrenFORnhrY2R1cUNkUU5qQWtYa0M3aUdaS0E3MUNDYVlEaTRJdjVmMDd4cnVJOHN5b1ZwakE2TFg5VThNelJFekN5bUZtMXpJODNUelllUWhJYTUxZVVsd2oxbzVDQlBxSnpZc3lXUjhsK0VZNmZrbytSQlNxYjFsZ0VTSjFLWFZDZTNRdXpwUm5zWWRsS3R6WG5hditNbDZoQUUxOVlwN1RrdWhxdU9ZSmNyeWFzQXI1VXhNQ1dTOS9GMmREbGg2cVZOU0lUb2w5NkVscm51a0krZVRMa0tjemVVeUNKdUx1dGFyRi9TUFJyYVR4VVFtSW5EckNmYkNkMTk5R09hNEsrMW1TcitxYzNpQ0h3S2pac01NYjNVUTVwMUtHRk9DbnlWMkUwaGppcW85Rk0xM2pUaGdQaVhQTzUwcEtlQzlxMmNENFZDekJBdllzei9TM3VnT0c1bXJnNHJNZ1g2Tk1nckJRT0grWkNNNVFCeDkyU1lDWFZnUXJOdFh4ZDJVQW4vdldhTmNDUkxBZnR6WDdidnJjd04xVGVuSElqTzMwL1lUUVJvY0h3SnBnTEFDRU0xeXo4VUtoYUFYdUxrZm9sRjUyMXVCQXJNNkdmMjg2Mm1pRTBjUzUvM2Y0YUNId2NQS3JBWVhWVzJndnNNTHM0SVlXZFIrMnR2a2dtRlBUY3F1NVV1SE1uUUtESmpucUhpY3QvalVjb0RwcHpyMVFZNzZCREUyNGNaN3FrMitzeTl2SytsRmsvNmNqVFVrTU9qWEFIcUxiSC95QWZFRGRsdnc5RjhzVkRHY0Y0OHRKbz0=';
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
	var efectivo

	if(parseInt(document.getElementById("efectivo").value) == ""){
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

function modalFactura(idreservaciones, total_mxn, idusuario) {
	$("#dateRfc").val(getFechaLocal() + " " + horaActual);
	$("#idreservacionrfc").val(idreservaciones);
	$("#amountRfc").val(total_mxn);
	$("#folioRfc").val(idusuario + "02" + idreservaciones);
	$("#myModal").show();
	$("#load").hide();
	$("#qr").hide();
	$("#factura").hide();
	$("#xml").hide();

}

function getFactura() {
	var option = document.getElementById('pymentTypeRfc').value;
	if (option == '03' && document.getElementById('referencesRfc').value == "") {
		bootbox.alert("Debes agregar una referencua bancaria");
	} else {
		$("#load").show();
		var formData = new FormData($("#formRfc")[0]);
		$.ajax({
			url: "../ajax/reservaciones.php?op=facturar",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function (data) {
				updateReserva()
				deserializar(data);
				$("#load").hide();
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				bootbox.alert("Error al intentar facturar");
			}
		});
	}
}

function deserializar(data) {
	var information = JSON.parse(data);

	if (information.AckEnlaceFiscal.estatusDocumento == "aceptado") {
		cfdi = information.AckEnlaceFiscal.descargaXmlCFDi;
		facturaPdf = information.AckEnlaceFiscal.descargaArchivoPDF;
		qr = information.AckEnlaceFiscal.descargaArchivoQR;
		$("#qr").show();
		$("#factura").show();
		$("#xml").show();
		$("#cfdi").val("" + cfdi);
		$("#facturaPdf").val("" + facturaPdf);
		$("#qrRfc").val("" + qr);
		salvarFactura();
	} else {
		bootbox.alert(information.AckEnlaceFiscal.mensajeError.descripcionError);
	}

}

function descarFactura() {
	window.open(facturaPdf);
}

function descarQr() {
	window.open(qr);
}

function descarCfdi() {
	window.open(cfdi);
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

function salvarFactura() {
	var formData = new FormData($("#formRfc")[0]);
	$.ajax({
		url: "../ajax/reservaciones.php?op=guardarFactura",
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
		.EscribirTexto("TICKET DE RESERVACION - " + datos.tipo_pago.substring(0, 1)  + datos.idreservaciones )
		.EscribirTexto("\n\n\n\n\n")
		.Feed(1)
		.CorteParcial()
		.imprimirEn(nombreImpresora);
}

init();
