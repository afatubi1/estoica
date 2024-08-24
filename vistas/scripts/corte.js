var tabla;
var usuario;

//Función que se ejecuta al inicio
function init() {

	mostrarform(false);
	listar();


	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});
	//Cargamos los items al select proveedo
}

//Función limpiar
function limpiar() {
	$("#corte_usuario").val("");
	$("#turno").val("");
	$("#cincuentaCentavos").val("0");
	$("#unPeso").val("0");
	$("#dosPesos").val("0");
	$("#cincoPesos").val("0");
	$("#diezPesos").val("0");
	$("#veintePesos").val("0");
	$("#billeteVeinte").val("0");
	$("#billeteCincuenta").val("0");
	$("#billeteCien").val("0");
	$("#billeteDoscientos").val("0");
	$("#billeteQuinientos").val("0");
	$("#billeteMil").val("0");
	$("#total_pesos").val("0");
	$("#dolarUno").val("0");
	$("#dolarDos").val("0");
	$("#dolarCinco").val("0");
	$("#dolarDiez").val("0");
	$("#dolarVeinte").val("0");
	$("#dolarCincuenta").val("0");
	$("#dolarCien").val("0");
	$("#total_dolar").val("0");

	$(".filas").remove();


	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear() + "-" + (month) + "-" + (day);
	$('#corte_fecha').val(today);

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
		detalles = 0;
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
				url: '../ajax/corte.php?op=listar',
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 20,//Paginación
			"order": [[0, "desc"]]//Ordenar (columna,orden)
		}).DataTable();
}


function guardaryeditar(e) {
	e.preventDefault();

	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/corte.php?op=guardaryeditar",
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

$("#btnTotalPesos").click(function () {
	totalPesos()
});

$("#btnTotalDolar").click(function () {
	totalDolar()
});

$("#btnTotalImprimir").click(function () {
	getUsuario()
});

function totalPesos() {
	var cincuentaCentavos = document.getElementById('cincuentaCentavos').value;
	var unPeso = document.getElementById('unPeso').value;
	var dosPesos = document.getElementById('dosPesos').value;
	var cincoPesos = document.getElementById('cincoPesos').value;
	var diezPesos = document.getElementById('diezPesos').value;
	var veintePesos = document.getElementById('veintePesos').value;
	var billeteVeinte = document.getElementById('billeteVeinte').value;
	var billeteCincuenta = document.getElementById('billeteCincuenta').value;
	var billeteCien = document.getElementById('billeteCien').value;
	var billeteDoscientos = document.getElementById('billeteDoscientos').value;
	var billeteQuinientos = document.getElementById('billeteQuinientos').value;
	var billeteMil = document.getElementById('billeteMil').value;
	var a = cincuentaCentavos * .50;
	var b = unPeso * 1;
	var c = dosPesos * 2;
	var d = cincoPesos * 5;
	var e = diezPesos * 10;
	var f = veintePesos * 20;
	var g = billeteVeinte * 20;
	var h = billeteCincuenta * 50;
	var i = billeteCien * 100;
	var j = billeteDoscientos * 200;
	var k = billeteQuinientos * 500;
	var l = billeteMil * 1000;
	let total_pesos = a + b + c + d + e + f + g + h + i + j + k + l;
	$("#total_pesos").val(total_pesos);

}

function totalDolar() {
	var dolarUno = document.getElementById('dolarUno').value;
	var dolarDos = document.getElementById('dolarDos').value;
	var dolarCinco = document.getElementById('dolarCinco').value;
	var dolarDiez = document.getElementById('dolarDiez').value;
	var dolarVeinte = document.getElementById('dolarVeinte').value;
	var dolarCincuenta = document.getElementById('dolarCincuenta').value;
	var dolarCien = document.getElementById('dolarCien').value;
	var a = dolarUno * 1;
	var b = dolarDos * 2;
	var c = dolarCinco * 5;
	var d = dolarDiez * 10;
	var e = dolarVeinte * 20;
	var f = dolarCincuenta * 50;
	var g = dolarCien * 100;
	let total_dolar = a + b + c + d + e + f + g;
	$("#total_dolar").val(total_dolar);
}

function imprimir(nombre) {
	var nombre = nombre;
}

function getUsuario(){
	$.ajax({
		url: "../ajax/corte.php?op=getUsuario",
		type: "POST",
		contentType: false,
		processData: false,

		success: function (datos) {
			usuario = datos;
			imprimirCorte();
		}
	});
}

async function imprimirCorte() {
	const serial = 'NmY4NjdkYWJfXzIwMjQtMDQtMDFfXzIwMjQtMDYtMzAjIyNia2FXaE5IZFcrZC9XZ2M5VzNMYjRLcWhzbWNpWW9XbHJycmttNDdMeDlManZwaGYxMnVTOHA5QnNmbDVVSGV5MjRyaUt2eGsxbjRQUllYK0huNXk3SEp1OXNuNUZ5TDJ0WFNUYUFEdG5qOGU3dzUvcXFCd3ZmMHBNRVJzenJLTUltYTE0TitvQ3dEY3pEWEllWC9pUEpPVXRNdlN1MGpxbDdhaXFaM09vTlhwUmxENzhKWkhoTzFNTFd0bHVEVVlXWW5EVzlUY3F3cUw1eDZlUEljOFZPcDJQeTFTTmxoZHhCODVuZHFTaWdVMCtZUFJkRUFSbjN3TUorMitiUVJDeTFpK1RYWnlwYW1SSFcvcG5zbDdvSU5KWXN3YjJ3RlBRd2hoNlJBbTFERS9Bd20wbm9YRlRmWjBhSHlTSGIzeHdqMGhEc05Dc1ZGSmtCa21WaEZlNlBBbTJwN2YzOFZDVlRDL2tTYWZjcnlHNUxzak9lZlA5NGsxMXpyS1JTT1NMM0pzMUtFcjNTVUNOR3lMNXZ6bjk4TmdtV2g4OU1LYzZiZWRwY29lYXFRQTFhd3U5YnNTSGdLSDJPU3J2cWphVmJqUnZPZWNtUGhlS3J3eVNlM1hIRFFZSUowbnpiZi9ORDNWSkZPSDBUZTMrUUZDZ2xwYkdQYUNuL1RhSThkRG1yWS8rSnR3UFdleHQzbVNZaHZ4VGJQdUkrdzNwQ1BxYkI4VjU4ZFJFVmZpZGo4WXJzaXFJMW95NTZscmhhTFVwTC9Ld2FaS1czTHhFSU81R2VUdnZuc1l2MXlUNlFZWXZXNjR1UFJBNHJPL2VYUHM0aVdyR3hFcGlSRlY3MmFGK3IxOEJ2TXlnK0lGWndqKzRGNkw2REdIZkE2QlZ1cEFCK3hMdTVCYTVNTT0=';
	const nombreImpresora = "impresora";
	const conector = new ConectorPluginV3(null, serial);
		const respuesta = await conector
			.Iniciar()
			.EstablecerAlineacion(ConectorPluginV3.ALINEACION_CENTRO)
			.EscribirTexto("\n\n")
			.EstablecerAlineacion(ConectorPluginV3.ALINEACION_IZQUIERDA)
			.EstablecerTamañoFuente(1, 1)
			.EscribirTexto("Vendedor : "+usuario+"\n")
			.EscribirTexto("Fecha : "+document.getElementById('corte_fecha').value+"\n")
			.EscribirTexto("----Total en Pesos ---- : \n")
			.EscribirTexto("Moneda 50c: "+document.getElementById('cincuentaCentavos').value+"\n")
			.EscribirTexto("Moneda 1$: "+document.getElementById('unPeso').value+"\n")
			.EscribirTexto("Moneda 2$: "+document.getElementById('dosPesos').value+"\n")
			.EscribirTexto("Moneda 5$: "+document.getElementById('cincoPesos').value+"\n")
			.EscribirTexto("Moneda 10$: "+document.getElementById('diezPesos').value+"\n")
			.EscribirTexto("Moneda 20$: "+document.getElementById('veintePesos').value+"\n")
			.EscribirTexto("Billete 20$: "+document.getElementById('billeteVeinte').value+"\n")
			.EscribirTexto("Billete 50$: "+document.getElementById('billeteCincuenta').value+"\n")
			.EscribirTexto("Billete 100$: "+document.getElementById('billeteCien').value+"\n")
			.EscribirTexto("Billete 200$: "+document.getElementById('billeteDoscientos').value+"\n")
			.EscribirTexto("Billete 500$: "+document.getElementById('billeteQuinientos').value+"\n")
			.EscribirTexto("Billete 1000$: "+document.getElementById('billeteMil').value+"\n")
			.EscribirTexto("Total en pesos: "+document.getElementById('total_pesos').value+"\n")
			.EscribirTexto("---- Total en Dolares ---- : \n")
			.EscribirTexto("Total en pesos: "+document.getElementById('dolarUno').value+"\n")
			.EscribirTexto("Total en pesos: "+document.getElementById('dolarDos').value+"\n")
			.EscribirTexto("Total en pesos: "+document.getElementById('dolarCinco').value+"\n")
			.EscribirTexto("Total en pesos: "+document.getElementById('dolarDiez').value+"\n")
			.EscribirTexto("Total en pesos: "+document.getElementById('dolarVeinte').value+"\n")
			.EscribirTexto("Total en pesos: "+document.getElementById('dolarCincuenta').value+"\n")
			.EscribirTexto("Total en pesos: "+document.getElementById('dolarCien').value+"\n")
			.EscribirTexto("Total en pesos: "+document.getElementById('total_pesos').value+"\n")
			.EscribirTexto("Total en dolar: "+document.getElementById('total_dolar').value+"\n")
			.Feed(1)
			.EstablecerTamañoFuente(2, 2)
			.EscribirTexto("Corte de caja")
			.EscribirTexto("\n\n\n\n\n")
			.CorteParcial()
			.imprimirEn(nombreImpresora);
 
}
init();
