var tabla;
var horaActual;
var usuario;
var pagoEfectivo = false;
var serial = 'NmY4NjdkYWJfXzIwMjQtMDQtMDFfXzIwMjQtMDYtMzAjIyNia2FXaE5IZFcrZC9XZ2M5VzNMYjRLcWhzbWNpWW9XbHJycmttNDdMeDlManZwaGYxMnVTOHA5QnNmbDVVSGV5MjRyaUt2eGsxbjRQUllYK0huNXk3SEp1OXNuNUZ5TDJ0WFNUYUFEdG5qOGU3dzUvcXFCd3ZmMHBNRVJzenJLTUltYTE0TitvQ3dEY3pEWEllWC9pUEpPVXRNdlN1MGpxbDdhaXFaM09vTlhwUmxENzhKWkhoTzFNTFd0bHVEVVlXWW5EVzlUY3F3cUw1eDZlUEljOFZPcDJQeTFTTmxoZHhCODVuZHFTaWdVMCtZUFJkRUFSbjN3TUorMitiUVJDeTFpK1RYWnlwYW1SSFcvcG5zbDdvSU5KWXN3YjJ3RlBRd2hoNlJBbTFERS9Bd20wbm9YRlRmWjBhSHlTSGIzeHdqMGhEc05Dc1ZGSmtCa21WaEZlNlBBbTJwN2YzOFZDVlRDL2tTYWZjcnlHNUxzak9lZlA5NGsxMXpyS1JTT1NMM0pzMUtFcjNTVUNOR3lMNXZ6bjk4TmdtV2g4OU1LYzZiZWRwY29lYXFRQTFhd3U5YnNTSGdLSDJPU3J2cWphVmJqUnZPZWNtUGhlS3J3eVNlM1hIRFFZSUowbnpiZi9ORDNWSkZPSDBUZTMrUUZDZ2xwYkdQYUNuL1RhSThkRG1yWS8rSnR3UFdleHQzbVNZaHZ4VGJQdUkrdzNwQ1BxYkI4VjU4ZFJFVmZpZGo4WXJzaXFJMW95NTZscmhhTFVwTC9Ld2FaS1czTHhFSU81R2VUdnZuc1l2MXlUNlFZWXZXNjR1UFJBNHJPL2VYUHM0aVdyR3hFcGlSRlY3MmFGK3IxOEJ2TXlnK0lGWndqKzRGNkw2REdIZkE2QlZ1cEFCK3hMdTVCYTVNTT0=';

//Función que se ejecuta al inicio
function init() {
	getHours();
	setInterval(getHours, 30000);
	mostrarform(false);
	listar();
	getUsuario();
	$("#cambioEfectivo").val("0");
	$("#efectivo").val("0");
	getFolioVenta();

	$("#formulario").on("submit", function (e) {
		calculaCambio();
		guardaryeditar(e);
		if (pagoEfectivo) {
			guardarVentaEfectivo(e)
		}
	});
	//Cargamos los items al select proveedor
	$.post("../ajax/venta.php?op=selectUnidad", function (r) {
		$("#idunidad").html(r);
		$('#idunidad').selectpicker('refresh');
	});

	$.post("../ajax/venta.php?op=selectRuta", function (r) {
		$("#idrutas").html(r);
		$('#idrutas').selectpicker('refresh');
	});

	//$.post("../ajax/venta.php?op=selectClientes", function (r) {
	//	$("#clientes").html(r);
	//	$('#clientes').selectpicker('refresh');
	//});

	$.post("../ajax/venta.php?op=getIdVentaEfectivo", function (r) {
		$("#idefectivo").val(r);
	});
}

function calculaCambio() {

	var efectivo = parseInt(document.getElementById("efectivo").value);
	var totalMxn = parseInt(document.getElementById("total_mxn").value);
	cambio = efectivo - totalMxn;
	if (totalMxn > efectivo) {
		$("#cambioEfectivo").val(0);
	} else {
		$("#cambioEfectivo").val(cambio);
	}
}

function getIdEfectivo() {
	$.post("../ajax/venta.php?op=getIdVentaEfectivo", function (r) {
		$("#idefectivo").val(r);
	});
}

function getFolioVenta() {
	$.post("../ajax/venta.php?op=getFolioVenta", function (r) {
		$("#idFolioVenta").val(r);
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
	var compara = document.getElementById("usuario").value;
	if (compara == 32 || compara == 27 || compara == 35) {
		buttons1 = [
			'copyHtml5',
			'excelHtml5',
			'csvHtml5',
			'pdf'
		]
	} else {
		buttons1 = [
			'copyHtml5',
			'excelHtml5',
			'csvHtml5',
			'pdf'
		]
	}
	tabla = $('#tbllistado').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: buttons1,
			"ajax":
			{
				url: '../ajax/venta.php?op=listar',
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
	$.ajax({
		url: "../ajax/venta.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {
			print(datos, 1)
			bootbox.alert("Imprimiendo el ticket " + datos);
			mostrarform(false);
			getIdEfectivo();

		}

	});

}

//Funcion guardar id venta efectivo
function guardarVentaEfectivo(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	fillTicket();
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../ajax/venta.php?op=guardarIdEfectivo",
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

$("#btnCalculaDolar").click(function () {
	convertPesoDolar()
});

$("#btnKilometro").click(function () {
	convertPesoKilometros()
});

function fillTicket() {
	//$('#destino_save').val(fillRutas());
	$('#unidad_save').val(fillUnidad());
}

function fillRutas() {
	var selectElement = document.getElementById("idrutas");
	// Obtener el valor seleccionado
	var selectedValue = selectElement.value;
	// Obtener todos los valores en el elemento "select"
	var options = selectElement.options;
	var values = [];
	var destino
	for (var i = 0; i < options.length; i++) {
		values.push(options[i].text);
		if (options[i].value == selectedValue) {
			destino = options[i].text
		}
	}
	return destino;
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

function convertPesoDolar() {
	var dolar = document.getElementById('labelDolar').value;
	var pesos = document.getElementById('total_mxn').value;
	let a = pesos / dolar;
	$("#total_usd").val(a);
}

function convertPesoKilometros() {
	var kilometro = document.getElementById('kilometro').value;
	var option = document.getElementById('auto').value;
	if (option == 'Sedan') {
		$("#total_mxn").val(17 * kilometro);
	} else {
		$("#total_mxn").val(25 * kilometro);
	}
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

function modalFactura(idventa, num_comprobante, idusuario) {
	$("#dateRfc").val(getFechaLocal() + " " + horaActual);
	$("#idventarfc").val(idventa);
	$("#amountRfc").val(num_comprobante);
	$("#folioRfc").val(idusuario + "00" + idventa);
	$("#myModal").modal();
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
			url: "../ajax/venta.php?op=facturar",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function (data) {
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
		url: "../ajax/venta.php?op=guardarFactura",
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


function print(idventa, impreNumber = 1) {
	var formData = new FormData();
	formData.append('idventa', idventa);
	$.ajax({
		url: "../ajax/venta.php?op=getVenta",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			reprint(datos, impreNumber)

		}
	});
}

async function reprint(datos, impreNumber) {
	var datos = JSON.parse(datos);
	const nombreImpresora = "impresor";
	const conector = new ConectorPluginV3(null, serial);
	for (var i = 0; i < impreNumber; i++) {
		const respuesta = await conector
			.Iniciar()
			.EstablecerAlineacion(ConectorPluginV3.ALINEACION_CENTRO)
			.DescargarImagenDeInternetEImprimir("https://taxalaifa.com/taxal/taxal2.png", ConectorPluginV3.TAMAÑO_IMAGEN_NORMAL, 160)
			.EscribirTexto("\n\n")
			.EstablecerAlineacion(ConectorPluginV3.ALINEACION_IZQUIERDA)
			.EstablecerTamañoFuente(4, 4)
			.EstablecerTamañoFuente(1, 1)
			.EscribirTexto("Vendedor: " + datos.usuario + "\n")
			.EscribirTexto("Fecha: " + datos.fecha + "\n")
			.EscribirTexto("Hora: " + datos.hora + "\n")
			.EscribirTexto("Destino: " + datos.ruta + "\n")
			.EscribirTexto("Kilometros: " + datos.kilometro + "\n")
			.EscribirTexto("Pasajeros: " + datos.serie_comprobante + "\n")
			.EscribirTexto("Unidad: " + datos.clave + datos.placa + "\n")
			.EscribirTexto("Auto: " + datos.tipo_comprobante + "\n")
			.EscribirTexto("Tipo de pago: " + datos.tipo_pago + "\n")
			.EscribirTexto("Numero de ticket: " + datos.ticket_num + "\n")
			.EscribirTexto("Total MXN: $" + datos.num_comprobante + ".00" + "\n")
			.EscribirTexto("Total USD: $" + datos.impuesto + ".00" + "\n")
			.EscribirTexto("Efectivo: $" + datos.efectivo + ".00" + "\n")
			.EscribirTexto("Cambio efectivo: $" + datos.cambioEfectivo + ".00" + "\n")
			.EscribirTexto("Folio Venta: " + datos.idventa + "\n")
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
		window.location.reload();
	}
}

let inactivityTimer;

function resetInactivityTimer() {
	// Borra el temporizador existente si hay uno
	clearTimeout(inactivityTimer);

	// Establece un nuevo temporizador para 5 minutos (300,000 milisegundos)
	inactivityTimer = setTimeout(function () {
		// Recarga la página cuando se alcanza el tiempo de inactividad
		location.reload();
	}, 300000); // 5 minutos en milisegundos
}

// Agrega un evento de escucha para restablecer el temporizador en varias interacciones del usuario
document.addEventListener('mousemove', resetInactivityTimer);
document.addEventListener('keydown', resetInactivityTimer);

// Inicia el temporizador cuando se carga la página
resetInactivityTimer();

init();
