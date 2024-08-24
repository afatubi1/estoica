var tabla;

function init() {
	listar();
}

//Función Listar
function listar(ticketNum) {
	tabla = $('#tbllistado').dataTable(
		{
			"aProcessing": true, // Activamos el procesamiento del datatables
			"aServerSide": true, // Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip', // Definimos los elementos del control de tabla
			buttons: [
				'copyHtml5',
				'excelHtml5',
				'csvHtml5',
				'pdf'
			],
			"ajax": {
				url: '../ajax/saleCut.php?op=listar',
				type: "get",
				data: {
					ticketNum: ticketNum
				},
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 100, // Paginación
			"order": [[0, "desc"]] // Ordenar (columna,orden)
		}).DataTable();
}

function listForTicket() {
	var ticketNum = $('#ticketNum').val();
	
    if(ticketNum ==""){
		bootbox.alert("Ingresa el numero de un ticket");
	}else{
	// Obtén el valor del input
	tabla = $('#tbllistado').dataTable(
		{
			"aProcessing": true, // Activamos el procesamiento del datatables
			"aServerSide": true, // Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip', // Definimos los elementos del control de tabla
			buttons: [
				'copyHtml5',
				'excelHtml5',
				'csvHtml5',
				'pdf'
			],
			"ajax": {
				url: '../ajax/saleCut.php?op=listForTicket',
				type: "POST",
				data: {
					ticketNum: ticketNum
				},
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 100, // Paginación
			"order": [[0, "desc"]] // Ordenar (columna,orden)
		}).DataTable();
	}

}
init();