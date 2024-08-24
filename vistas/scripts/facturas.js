var tabla;

//Funcion que se ejecuta al inicio
function init() {
	listar();
}

//Funcion listar
function listar() {
	tabla = $('#tblistado')
		.dataTable(
			{
				"aProcessing": true, //Activamos el procesamiento del datatables
				"aServerSide": true, //Paginacion y filtrado realizados por el servidor
				dom: "Bfrtip", //Definimos los elementos del control de tabla
				buttons: [
					'copyHtml5',
					'excelHtml5',
					'csvHtml5',
					'pdf'
				],
				"ajax": {
					url: '../ajax/facturas.php?op=listarFacturas',
					type: "get",
					dataType: "json",
					error: function (e) {
						console.log(e.responseText);
					}
				},
				"bDestroy": true,
				"iDisplayLength": 50, //Paginacion
				"order": [[0, "desc"]] //Ordenar (Columna, orden)

			})
		.DataTable();
}

function getInfoXml(idfactura) {
	$("#idfactura").val(idfactura);
	var formData = new FormData($("#formRfc")[0]);
	$.ajax({
		url: "../ajax/facturas.php?op=getXML",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (data) {
			url = data.replace("&amp;b=1", "&b=1");
			window.open(url);
		},
		error: function (XMLHttpRequest, textStatus, errorThrown) {
			bootbox.alert("Error al intentar abrir");
		}
	});
}

function getInfoFactura(idfactura) {
	$("#idfactura").val(idfactura);
	var formData = new FormData($("#formRfc")[0]);
	$.ajax({
		url: "../ajax/facturas.php?op=getFactura",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (data) {
			url = data.replace("&amp;b=1", "&b=1");
			window.open(url);
		},
		error: function (XMLHttpRequest, textStatus, errorThrown) {
			bootbox.alert("Error al intentar abrir");
		}
	});
}

function getInfoQr(idfactura) {
	$("#idfactura").val(idfactura);
	var formData = new FormData($("#formRfc")[0]);
	$.ajax({
		url: "../ajax/facturas.php?op=getQr",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (data) {
			url = data.replace("&amp;b=1", "&b=1");
			window.open(url);
		},
		error: function (XMLHttpRequest, textStatus, errorThrown) {
			bootbox.alert("Error al intentar abrir");
		}
	});
}

init();