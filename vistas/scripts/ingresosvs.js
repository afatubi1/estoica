var tabla;

function init() {
    $("#formLiquidacion").on("submit", function (e) {
        guardaryeditar(e);
    });
    $.post("../ajax/venta.php?op=selectUnidad", function (r) {
        $("#idunidad").html(r);
        $('#idunidad').selectpicker('refresh');
    });
}


function fillIngresos() {
    const fechaInicio = $('#fechaInicio').val();
    const fechaFin = $('#fechaFin').val();
    const idunidad = $('#idunidad').val();

    if (!fechaInicio || !fechaFin || !idunidad) {
        alert("Por favor completa todos los campos.");
        return;
    }

    $.ajax({
        url: "../ajax/egresovs.php?op=listar",
        type: 'POST',
        data: {
            fechaInicio: fechaInicio,
            fechaFin: fechaFin,
            idunidad: idunidad
        },
        dataType: 'json',
        success: function (data) {
            if (data.error) {
                alert(data.error);
            } else {
                totales(data.aaData);
                guardaTotalDia(data.aaData)
                if ($.fn.DataTable.isDataTable('#resultadosTable')) {
                    $('#resultadosTable').DataTable().clear().destroy();
                }

                $('#resultadosTable').DataTable({
                    data: data.aaData,
                    columns: [
                        { title: "Fecha" },
                        { title: "Hora" },
                        { title: "Nombre" },
                        { title: "Unidad" },
                        { title: "Tipo Pago" },
                        { title: "Efectivo" },
                        { title: "Tarjeta" },
                        { title: "Dólar" },
                        { title: "CxC" },
                        { title: "transferencias" },
                        { title: "ID Venta" }
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            text: 'Exportar a Excel',
                            title: 'Reporte de Ingresos'
                        },
                        {
                            extend: 'pdfHtml5',
                            text: 'Exportar a PDF',
                            title: 'Reporte de Ingresos',
                            orientation: 'landscape',
                            pageSize: 'A4'
                        }
                    ]
                });
            }
        },
        error: function (xhr, status, error) {
            console.error('Error al realizar la solicitud:', error + status);
            alert("Error al realizar la solicitud.");
        }
    });
}

function fillEgresos() {
    const fechaInicio = $('#fechaInicio').val();
    const fechaFin = $('#fechaFin').val();
    const idunidad = $('#idunidad').val();

    $.ajax({
        url: '../ajax/egresovs.php?op=listarEgresos',
        type: 'POST',
        data: {
            fechaInicio: fechaInicio,
            fechaFin: fechaFin,
            idunidad: idunidad
        },
        dataType: 'json',
        success: function (data) {
            if (data.error) {
                alert(data.error);
            } else {
                totalesGastos(data.aaData);

                if ($.fn.DataTable.isDataTable('#tbllistado')) {
                    $('#tbllistado').DataTable().clear().destroy();
                }

                $('#tbllistado').DataTable({
                    data: data.aaData,
                    columns: [
                        { title: "Usuario" },
                        { title: "Folio" },
                        { title: "Fecha" },
                        { title: "Hora" },
                        { title: "Movimiento" },
                        { title: "Clave" },
                        { title: "Concepto clave" },
                        { title: "Folio externo" },
                        { title: "Unidad" },
                        { title: "Descripción" },
                        { title: "Forma de pago" },
                        { title: "Ingreso" },
                        { title: "Egresos" }
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            text: 'Exportar a Excel',
                            title: 'Reporte de Egresos'
                        },
                        {
                            extend: 'pdfHtml5',
                            text: 'Exportar a PDF',
                            title: 'Reporte de Egresos',
                            orientation: 'landscape',
                            pageSize: 'A4'
                        }
                    ]
                });
            }
        },
    });
}

function totales(data) {
    var sumaEfectivo = 0;
    var sumaTarjeta = 0;
    var sumaDolar = 0;
    var sumaCxc = 0;
    var sumaTransferencias = 0;

    data.forEach(registro => {
        sumaEfectivo += parseFloat(fillZero(registro[5], 10));
    });

    data.forEach(registro => {
        sumaTarjeta += parseFloat(fillZero(registro[6], 10));
    });

    data.forEach(registro => {
        sumaDolar += parseFloat(fillZero(registro[7], 10));
    });

    data.forEach(registro => {
        sumaCxc += parseFloat(fillZero(registro[8], 10));
    });

    data.forEach(registro => {
        sumaTransferencias += parseFloat(fillZero(registro[8], 10));
    });

    $("#textEfectivo").val(sumaEfectivo);
    $("#textTarjeta").val(sumaTarjeta);
    $("#textDolar").val(sumaDolar);
    $("#textCxc").val(sumaCxc);
    $("#texttransferencias").val(sumaTransferencias);
    $("#totalIngreso").val(sumaEfectivo + sumaTarjeta + sumaTransferencias);
    total();
}

function fillZero(variable) {
    if (variable == "0" || variable == "") {
        return "0"
    } else {
        return variable
    }
}

function totalesGastos(data) {
    var sumaIngreso = 0.0;
    var sumaGasto = 0.0;


    data.forEach(registro => {
        sumaIngreso += parseFloat(fillZero(registro[11], 13));
    });

    data.forEach(registro => {
        sumaGasto += parseFloat(fillZero(registro[12], 13));
    });

    $("#textIngreso").val(sumaIngreso);
    $("#textGastos").val(sumaGasto);
    $("#totalgasto").val(sumaIngreso - sumaGasto);
    total();
}

function total() {
    const totalgasto = document.getElementById('totalgasto').value;
    const totalIngreso = document.getElementById('totalIngreso').value;
    convertirAPositivo(totalgasto);

    if (totalgasto == 0 || totalIngreso == 0) {
        return;
    } else {
        $("#total").val(totalIngreso - convertirAPositivo(totalgasto))
    }

}

function fillUnidad() {
    var selectElement = document.getElementById("idunidad");
    var selectedValue = selectElement.value;
    var options = selectElement.options;
    var unidad;

    for (var i = 0; i < options.length; i++) {
        if (options[i].value == selectedValue) {
            unidad = options[i].text;
            break;
        }
    }
    return unidad;
}

function convertirAPositivo(numero) {
    return Math.abs(numero);
}

let graficaTotal = null; // Variable global para la gráfica

function guardaTotalDia(datos) {
    const resultados = {};

    // Validar que los datos son un array de arrays
    if (!Array.isArray(datos) || !datos.length || !Array.isArray(datos[0])) {
        console.warn("Datos inválidos para graficar.");
        return;
    }

    // 💥 Limpiar gráfica anterior al inicio
    if (graficaTotal !== null) {
        graficaTotal.destroy();
        graficaTotal = null;
    }

    // Procesar datos
    datos.forEach(item => {
        const fecha = item[0];
        const valores = item.slice(5, 10).map(x => parseFloat(x) || 0);
        const suma = valores.reduce((a, b) => a + b, 0);

        if (!resultados[fecha]) {
            resultados[fecha] = 0;
        }

        resultados[fecha] += suma;
    });

    const resultadoFinal = Object.entries(resultados);
    const fechas = resultadoFinal.map(item => item[0]);
    const sumas = resultadoFinal.map(item => item[1]);

    // Validar canvas
    const canvas = document.getElementById('grafica');
    if (!canvas) {
        console.warn("No se encontró el elemento con id 'grafica'.");
        return;
    }

    const ctx = canvas.getContext('2d');

    // Crear nueva gráfica
    graficaTotal = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: fechas,
            datasets: [{
                label: 'Suma total',
                data: sumas,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Monto Total'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Fecha'
                    }
                }
            }
        }
    });
}



init();
