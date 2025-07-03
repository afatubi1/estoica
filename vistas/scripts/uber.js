function init() {
    listar();
}

function listar() {
	tabla = $('#tbllistado').DataTable({
		"aProcessing": true,
		"aServerSide": true,
		dom: 'Bfrtip',
		buttons: [
			'copyHtml5',
			'excelHtml5',
			'csvHtml5',
			'pdf'
		],
		"ajax": {
			url: '../ajax/ventaDos.php?op=listarUber',
			type: "get",
			dataType: "json",
			error: function (e) {
				console.log(e.responseText);
			}
		},
		"bDestroy": true,
		"iDisplayLength": 20,
		"order": [[0, "desc"]]
	});

	// Aquí escuchamos cuando DataTables termine de cargar los datos
	$('#tbllistado').on('xhr.dt', function (e, settings, json, xhr) {
		let conteo = {};
		// Asegúrate de acceder al arreglo correcto: json.data o json.aaData
		const datos = json.data || json.aaData;

		if (Array.isArray(datos)) {
			datos.forEach(function (item) {
				let unidad = item[2]; // Asegúrate que la posición 2 es "Unidad"
				conteo[unidad] = (conteo[unidad] || 0) + 1;
			});
			generarGrafica(conteo);
		}
	});
}


function generarGrafica(conteo) {
	const unidades = Object.keys(conteo);
	const frecuencias = Object.values(conteo);

	const ctx = document.getElementById('graficaUnidades').getContext('2d');
	new Chart(ctx, {
		type: 'bar',
		data: {
			labels: unidades,
			datasets: [{
				label: 'Numero de viajes',
				data: frecuencias,
				backgroundColor: 'rgba(71, 199, 106, 0.6)',
				borderColor: 'rgba(75, 192, 192, 1)',
				borderWidth: 1
			}]
		},
		options: {
			indexAxis: 'y', // horizontal
			scales: {
				x: {
					beginAtZero: true
				}
			}
		}
	});
}

init();