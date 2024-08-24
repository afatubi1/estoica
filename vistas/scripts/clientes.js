var tabla;

//Funcion que se ejecuta al inicio
function init() {
	listar();
}
function agregarCliente() {
	$("#myModal").modal();
}

function guardarCliente() {
	var formData = new FormData($("#formCliente")[0]);
	$.ajax({
		url: "../ajax/clientes.php?op=guardar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (data) {
			bootbox.alert("El cliente se guardo con exito");
			$('#myModal').modal('hide');
			listar();
		},
		error: function (XMLHttpRequest, textStatus, errorThrown) {
		}
	});
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
					url: '../ajax/clientes.php?op=listarClientes',
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

init();