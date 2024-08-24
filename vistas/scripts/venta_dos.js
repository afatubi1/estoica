var tabla;
var horaActual;
var usuario;
var pagoEfectivo = false;
var pagoDolar = false;
var pagoCxc = false;

var serial = 'NmY4NjdkYWJfXzIwMjQtMDgtMjJfXzIwMjQtMTAtMjEjIyNhbXZ1T0ExeG9IaUx5WHFlZDlhQzB6Q0tLN2lxa3ZxV0FsU1ErZmI3TXZVSDcvNG1oR2ZYVmkyc2NXeFdIRDNYZEo1TE9IeUNrenFORnhrY2R1cUNkUU5qQWtYa0M3aUdaS0E3MUNDYVlEaTRJdjVmMDd4cnVJOHN5b1ZwakE2TFg5VThNelJFekN5bUZtMXpJODNUelllUWhJYTUxZVVsd2oxbzVDQlBxSnpZc3lXUjhsK0VZNmZrbytSQlNxYjFsZ0VTSjFLWFZDZTNRdXpwUm5zWWRsS3R6WG5hditNbDZoQUUxOVlwN1RrdWhxdU9ZSmNyeWFzQXI1VXhNQ1dTOS9GMmREbGg2cVZOU0lUb2w5NkVscm51a0krZVRMa0tjemVVeUNKdUx1dGFyRi9TUFJyYVR4VVFtSW5EckNmYkNkMTk5R09hNEsrMW1TcitxYzNpQ0h3S2pac01NYjNVUTVwMUtHRk9DbnlWMkUwaGppcW85Rk0xM2pUaGdQaVhQTzUwcEtlQzlxMmNENFZDekJBdllzei9TM3VnT0c1bXJnNHJNZ1g2Tk1nckJRT0grWkNNNVFCeDkyU1lDWFZnUXJOdFh4ZDJVQW4vdldhTmNDUkxBZnR6WDdidnJjd04xVGVuSElqTzMwL1lUUVJvY0h3SnBnTEFDRU0xeXo4VUtoYUFYdUxrZm9sRjUyMXVCQXJNNkdmMjg2Mm1pRTBjUzUvM2Y0YUNId2NQS3JBWVhWVzJndnNNTHM0SVlXZFIrMnR2a2dtRlBUY3F1NVV1SE1uUUtESmpucUhpY3QvalVjb0RwcHpyMVFZNzZCREUyNGNaN3FrMitzeTl2SytsRmsvNmNqVFVrTU9qWEFIcUxiSC95QWZFRGRsdnc5RjhzVkRHY0Y0OHRKbz0=';

//Función que se ejecuta al inicio
function init() {
	$('#fecha_hora').val(getFechaLocal());
	getHours();
	setInterval(getHours, 30000);
	listar();
	getUsuario();
	getFolioVenta();
	setValues();
	hideElements();

	//Cargamos los items al select proveedor
	$.post("../ajax/ventaDos.php?op=selectUnidad", function (r) {
		$("#idunidad").html(r);
		$('#idunidad').selectpicker('refresh');
	});

	$.post("../ajax/ventaDos.php?op=getIdVentaEfectivo", function (r) {
		$("#idefectivo").val(r);
	});

	$.post("../ajax/ventaDos.php?op=getIdVentaDolar", function (r) {
		$("#idDolar").val(r);
	});

	$.post("../ajax/ventaDos.php?op=getIdVentaCxc", function (r) {
		$("#idCxc").val(r);
	});
}

function hideElements() {
	$("#formularioregistros").hide();
	$("#shouldPayment").hide();
	$("#shouldUnit").hide();
}

function habailablePrincipalForm() {
	$("#formularioregistros").show();
	$("#listadoregistros").hide();
}

function habailableTable() {
	$("#formularioregistros").hide();
	$("#listadoregistros").show();
}

function saveSales() {
	var tipoPago = document.getElementById('tipo_pago').value;
	var idUnidad = document.getElementById('idunidad').value;
	const paymentMethods = ["#Efectivo", "#Dolar", "#Tarjeta", "#CXC"];

	if (tipoPago === "SN") {
		$("#shouldPayment").show();
		return;
	} else if (idUnidad === "1") {
		$("#shouldUnit").show();
		return;
	} else if (hasMoreThanTwoValues(paymentMethods) === true){
		return;
	}

	setTotalValue();
	guardaryeditar();

	if (pagoEfectivo) {
		guardarVentaEfectivo();
	} else if (pagoDolar) {
		guardarVentaDolar();
	} else if (pagoCxc) {
		guardarVentaCxc();
	}
}

function hasMoreThanTwoValues(paymentMethods) {
    let count = 0;

    for (let method of paymentMethods) {
        if ($(method).val() !== "0") {
            count++;
        }
        // Si ya encontramos más de dos valores, podemos detener la búsqueda
        if (count > 2) {
            return true;
        }
    }

    return false;
}

function setTotalValue() {
    const paymentMethods = ["#Efectivo", "#Dolar", "#Tarjeta", "#CXC"];
    
    for (let method of paymentMethods) {
        let value = $(method).val();
        if (value !== "0") {
            $("#total_venta").val(value);
            break;
        }
    }
}

function setValues() {
	$("#Efectivo").val("0");
	$("#Dolar").val("0");
	$("#Tarjeta").val("0");
	$("#CXC").val("0");
}

function getIdEfectivo() {
	$.post("../ajax/ventaDos.php?op=getIdVentaEfectivo", function (r) {
		$("#idefectivo").val(r);
	});
}

function getIdEfectivo() {
	$.post("../ajax/ventaDos.php?op=getIdVentaDolar", function (r) {
		$("#idDolar").val(r);
	});
}
function getIdEfectivo() {
	$.post("../ajax/ventaDos.php?op=getIdVentaCxc", function (r) {
		$("#idCxc").val(r);
	});
}

function getFolioVenta() {
	$.post("../ajax/ventaDos.php?op=getFolioVenta", function (r) {
		$("#idFolioVenta").val(r);
	});
}

//Función limpiar
function limpiar() {
	$("#auto").selectpicker('refresh');
	habailableTable();
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
				url: '../ajax/ventaDos.php?op=listar',
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
function guardaryeditar() {
	fillTicket();
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../ajax/ventaDos.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			print(datos, 1)
			getIdEfectivo();
			limpiar();
			bootbox.alert("Imprimiendo el ticket " + datos);
		}

	});

}

//Funcion guardar id venta efectivo
function guardarVentaEfectivo() {
	fillTicket();
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../ajax/ventaDos.php?op=guardarIdEfectivo",
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

//Funcion guardar id venta efectivo
function guardarVentaDolar() {
	fillTicket();
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../ajax/ventaDos.php?op=guardarIdDolar",
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

//Funcion guardar id venta efectivo
function guardarVentaCxc() {
	fillTicket();
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../ajax/ventaDos.php?op=guardarIdCxc",
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

$(document).ready(function () {
	var previousValue = null;

	$('#tipo_pago').on('change', function (e) {
		$("#ticket_num").val("");

		var selectedValue = $(this).find("option:selected").val();

		// Ejecutar acción sin comparar el valor seleccionado
		ejecutarAccion(selectedValue);

		// Actualizar previousValue
		previousValue = selectedValue;
	});

	function ejecutarAccion(valor) {
		var acciones = {
			"Dolar": function () {
				setValuesPost("Dolar");
				saveFolio("Dolar");
			},
			"Efectivo": function () {
				setValuesPost("Efectivo");
				saveFolio("Efectivo");
			},
			"Tarjeta": function () {
				setValuesPost("Tarjeta");
				saveFolio("Tarjeta");
			},
			"Transferencia": function () {
				setValuesPost("Transferencia");
				saveFolio("Transferencia");
			},
			"CxC AereoMexico": function () {
				setValuesPost("CXC");
				saveFolio("CXC");
			},
			"CxC Volaris": function () {
				setValuesPost("CXC");
				saveFolio("CXC");
			},
			"CxC VivaAeroBus": function () {
				setValuesPost("CXC");
				saveFolio("CXC");
			},
			"CxC NADGlobal": function () {
				setValuesPost("CXC");
				saveFolio("CXC");
			},
			"Deudores Diversos": function () {
				setValuesPost("CXC");
				saveFolio("CXC");
			}
		};

		if (acciones[valor]) {
			acciones[valor]();
		} else {
			setValuesPost("Efectivo");
			pagoEfectivo = false;
		}
	}

	function saveFolio(foliType) {
		if (foliType == "Dolar") {
			var idDolar = parseInt($("#idDolar").val()) + 1;
			pagoEfectivo = false;
			pagoCxc = false;
			pagoDolar = true;
			$("#ticket_num").val("DOL-00" + idDolar);
			$("#folioVentaDolar").val("DOL-00" + idDolar);
		} else if (foliType == "Efectivo") {
			var idEfectivo = parseInt($("#idefectivo").val()) + 1;
			pagoEfectivo = true;
			pagoCxc = false;
			pagoDolar = false;
			$("#ticket_num").val("EFEC-00" + idEfectivo);
			$("#folioVentaEfectivo").val("EFEC-00" + idEfectivo);
		} else if (foliType == "CXC") {
			var idCxc = parseInt($("#idCxc").val()) + 1;
			pagoEfectivo = false;
			pagoCxc = true;
			pagoDolar = false;
			$("#ticket_num").val("CXC-00" + idCxc);
			$("#folioVentaCxc").val("CXC-00" + idCxc);
		} else {
			pagoEfectivo = false;
			pagoCxc = false;
			pagoDolar = false;
		}
	}


	// Forzar la ejecución del evento cuando la selección es la misma
	$('#tipo_pago').on('click', function () {
		if ($(this).val() === previousValue) {
			$(this).trigger('change');
		}
	});
});



function setValuesPost(paymentType) {
	var elements = ["Efectivo", "Dolar", "Tarjeta", "CXC"];

	elements.forEach(function (element) {
		if (element !== paymentType) {
			$("#" + element).val("0");
		}
	});
}


var idventarfc;
var cfdi;
var facturaPdf;
var qr;
var folioFactura;
var dateRfc;

function modalFactura(idventa, total_venta, idusuario, tipo_pago) {
	$("#dateRfc").val(getFechaLocal() + " " + horaActual);
	$("#idventarfc").val(idventa);
	$("#amountRfc").val(total_venta);
	$("#folioRfc").val(idusuario + "00" + idventa);
	$("#myModal").modal();
	$("#load").hide();
	$("#qr").hide();
	$("#factura").hide();
	$("#xml").hide();
}

function openModalAdd() {
	$("#modalSales").modal();
}

function hideModalAdd() {
	$("#modalSales").hide();
}

function getFactura() {
	$("#load").show();
	var formData = new FormData($("#formRfc")[0]);
	$.ajax({
		url: "../ajax/ventaDos.php?op=facturar",
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
			$("#load").hide();
		}
	});
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
		url: "../ajax/ventaDos.php?op=guardarFactura",
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
		url: "../ajax/ventaDos.php?op=getVenta",
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
	const nombreImpresora = "impresora";
	const conector = new ConectorPluginV3(null, serial);
	for (var i = 0; i < impreNumber; i++) {
		const respuesta = await conector
			.Iniciar()
			.EstablecerAlineacion(ConectorPluginV3.ALINEACION_CENTRO)
			.EscribirTexto("\n\n")
			.EstablecerAlineacion(ConectorPluginV3.ALINEACION_IZQUIERDA)
			.EstablecerTamañoFuente(4, 4)
			.EstablecerTamañoFuente(1, 1)
			.EscribirTexto("Vendedor: " + datos.usuario + "\n")
			.EscribirTexto("Fecha: " + datos.fecha + "\n")
			.EscribirTexto("Hora: " + datos.hora + "\n")
			.EscribirTexto("Destino: " + datos.ruta + "\n")
			.EscribirTexto("Kilometros: " + datos.kilometro + "\n")
			.EscribirTexto("Pasajeros: " + datos.pasajero + "\n")
			.EscribirTexto("Unidad: " + datos.clave + datos.placa + "\n")
			.EscribirTexto("Auto: " + datos.auto + "\n")
			.EscribirTexto("Tipo de pago: " + datos.tipo_pago + "\n")
			.EscribirTexto("Numero de ticket: " + datos.ticket_num + "\n")
			.EscribirTexto("Total efectivo: $" + datos.efectivo + ".00" + "\n")
			.EscribirTexto("Total dolar: $" + datos.dolar + ".00" + "\n")
			.EscribirTexto("Total Cuentas por cobrar: $" + datos.cxc + ".00" + "\n")
			.EscribirTexto("Total tarjeta: $" + datos.tarjeta + ".00" + "\n")
			.EscribirTexto("Folio Venta: " + datos.idventa + "\n")
			.Feed(1)
			.EstablecerAlineacion(ConectorPluginV3.ALINEACION_CENTRO)
			.EscribirTexto("Su destino incluye maximo el pago de un peaje.\n Las casetas exentas de pago son Segundo Piso de Periferico, Arco Norte, Chamapa la Venta y Siervo de la Nacion. Si deseas que tu ruta pase por alguna de estas casetas el pago sera absorbido por el cliente.\n\n")
			.EscribirTexto("Facturas:   estoicadrive@gmail.com\n")
			.EscribirTexto("Recoleccion y Reservaciones : +52 5536704952\n\n")
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