var tabla;
var horaActual; // No se utiliza en el código actual

function init() {
    $("#formLiquidacion").on("submit", function (e) {
        guardaryeditar(e);
    });
    // Cargar los items al select de proveedor
    $.post("../ajax/venta.php?op=selectUnidad", function (r) {
        $("#idunidad").html(r);
        $('#idunidad').selectpicker('refresh');
    });
}


function fillIngresos() {
    // Obtener los datos del formulario
    const fechaInicio = $('#fechaInicio').val();
    const fechaFin = $('#fechaFin').val();
    const idunidad = $('#idunidad').val();

    // Validación básica en el frontend
    if (!fechaInicio || !fechaFin || !idunidad) {
        alert("Por favor completa todos los campos.");
        return;
    }

    // Enviar la solicitud a PHP usando AJAX
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

                // Destruir cualquier instancia previa de DataTable
                if ($.fn.DataTable.isDataTable('#resultadosTable')) {
                    $('#resultadosTable').DataTable().clear().destroy();
                }

                // Inicializar la tabla con los datos recibidos
                $('#resultadosTable').DataTable({
                    data: data.aaData,
                    columns: [
                        { title: "Fecha" },
                        { title: "Hora" },
                        { title: "Unidad" },
                        { title: "Nombre" },
                        { title: "Tipo Pago" },
                        { title: "Efectivo" },
                        { title: "Tarjeta" },
                        { title: "Dólar" },
                        { title: "CxC" },
                        { title: "ID Venta" }
                    ],
                    dom: 'Bfrtip', // Habilitar botones
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
                            orientation: 'landscape', // Horizontal para mejor presentación
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

    // Enviar la solicitud a PHP usando AJAX
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
                // Llamada a la función que procesa los totales de gastos
                totalesGastos(data.aaData);

                // Destruir cualquier instancia previa de DataTable
                if ($.fn.DataTable.isDataTable('#tbllistado')) {
                    $('#tbllistado').DataTable().clear().destroy();
                }

                // Inicializar la tabla con los datos recibidos
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
                    dom: 'Bfrtip', // Habilitar botones
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
                            orientation: 'landscape', // Horizontal para mejor presentación
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

    $("#textEfectivo").val(sumaEfectivo);
    $("#textTarjeta").val(sumaTarjeta);
    $("#textDolar").val(sumaDolar);
    $("#textCxc").val(sumaCxc);
    $("#totalIngreso").val(sumaEfectivo + sumaTarjeta);
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

init();
