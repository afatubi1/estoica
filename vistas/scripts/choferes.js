var tabla;

//Funcion que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();
    showButtonsEdit(false);
}

//funcion limpiar
function limpiar() {
    $("#nombre").val("");
    $("#num_documento").val("");
    $("#direccion").val("");
    $("#telefono").val("");
    $("#email").val("");
    $("#idpersona").val("");
}

//funcion mostrar formulario
function mostrarform(flag) {
    limpiar();

    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    }
    else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

//Funcion cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
    showButtonsEdit(false);
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
                    url: '../ajax/persona.php?op=listarc',
                    type: "get",
                    dataType: "json",
                    error: function (e) {
                        console.log(e.responseText);
                    }
                },
                "bDestroy": true,
                "iDisplayLength": 25, //Paginacion
                "order": [[0, "desc"]] //Ordenar (Columna, orden)

            })
        .DataTable();
}

$("#btnCalculaDolar").click(function () {
	convertPesoDolar()
});

//funcion para guardar o editar
function guardaryeditar() {
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/persona.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            //console.log("succes");
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        },
        error: function (error) {
            console.log("error: " + error);
        }
    });

    limpiar();
}


$("#editarAntecedentesPenales").click(function () {
	editarAntecedentes();
});

$("#editarAptitudPsicofisica").click(function () {
	editarAptitud();
});

$("#editarComprobanteDomicilio").click(function () {
	editarComprobante();
});

$("#editarCurp").click(function () {
	editarCurp();
});

$("#editarIne").click(function () {
	editarIne();
});

$("#editarLicencia").click(function () {
	editarLicencia();
});

$("#editarTia").click(function () {
	editarTia();
});

$("#editarImagen").click(function () {
	editarImagen();
});

$("#btnGuardar").click(function () {
	guardaryeditar();
});

function editarAntecedentes() {
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/persona.php?op=editarAntecedentes",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            bootbox.alert(datos);
        },
        error: function (error) {
            console.log("error: " + error);
        }
    });

}

function editarAptitud() {
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/persona.php?op=editarAptitud",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            bootbox.alert(datos);
        },
        error: function (error) {
            console.log("error: " + error);
        }
    });

}

function editarComprobante() {
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/persona.php?op=editarComprobante",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            bootbox.alert(datos);
        },
        error: function (error) {
            console.log("error: " + error);
        }
    });

}

function editarCurp() {
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/persona.php?op=editarCurp",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            bootbox.alert(datos);
        },
        error: function (error) {
            console.log("error: " + error);
        }
    });

}



function editarImagen() {
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/persona.php?op=editarImagen",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            bootbox.alert(datos);
        },
        error: function (error) {
            console.log("error: " + error);
        }
    });

}

//funcion para guardar o editar
function editarIne() {
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/persona.php?op=editarIne",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            bootbox.alert(datos);
        },
        error: function (error) {
            console.log("error: " + error);
        }
    });
}

//funcion para guardar o editar
function editarLicencia() {
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/persona.php?op=editarLicencia",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            bootbox.alert(datos);
        },
        error: function (error) {
            console.log("error: " + error);
        }
    });
}

//funcion para guardar o editar
function editarTia() {
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/persona.php?op=editarTia",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            bootbox.alert(datos);
        },
        error: function (error) {
            console.log("error: " + error);
        }
    });
}

function info(idpersona) {
    $("#myModal").modal();
    fillInformationUser(idpersona);
}

function fillInformationUser(idpersona) {
    $.post(
        "../ajax/persona.php?op=mostrar",
        { idpersona: idpersona },
        function (data, status) {
            data = JSON.parse(data);
            $("#nombreChofermodal").html("Nombre : " + data.nombre);
            $("#imgChoferPerfil").attr("src", "" + data.imgChofer);
            $("#documentoChofer").html("Identificacion : " + data.tipo_documento);
            $("#telefonoChofer").html("Telefono : " + data.telefono);
            $("#telefonoRef").html("Telefono de referencia : " + data.telefonoReferencia);
            $("#emailChofer").html("Email : " + data.email);
            $("#direccionChofer").html("Direccion : " + data.direccion);
            linkIne = data.ine;
            linkLicencia = data.licencia;    
            linkTia = data.tia;
            linkCurp = data.Curp;
            linkComprobanteDomicilio = data.comprobanteDomicilio;
            linkAptitudPsicofisica = data.aptitudPsicofisica;
            linkAntecedentesPenales = data.antecedentesPenales;
        }
    );

}

var linkIne;
var linkLicencia;
var linkTia;

var linkCurp;
var linkComprobanteDomicilio;
var linkAptitudPsicofisica;
var linkAntecedentesPenales;

$("#btnCurp").click(function () {
    window.open(linkCurp);
});

$("#btnComprobante").click(function () {
    window.open(linkComprobanteDomicilio);
});

$("#btnAptitud").click(function () {
    window.open(linkAptitudPsicofisica);
});

$("#btnAntecedentes").click(function () {
    window.open(linkAntecedentesPenales);
});

$("#btnIne").click(function () {
    window.open(linkIne);
});

$("#btnLicencia").click(function () {
    window.open(linkLicencia);
});

$("#btnTia").click(function () {
    window.open(linkTia);
});

function mostrar(idpersona) {
    showButtonsEdit(true);
    $.post(
        "../ajax/persona.php?op=mostrar",
        { idpersona: idpersona },
        function (data, status) {
            data = JSON.parse(data);
            mostrarform(true);
            $("#nombreChofer").val(data.nombre);
            $("#tipo_documento").val(data.tipo_documento);
            $("#tipo_documento").selectpicker('refresh');
            $("#num_documento").val(data.num_documento);
            $("#direccion").val(data.direccion);
            $("#telefono").val(data.telefono);
            $("#email").val(data.email);
            $("#telefonoReferencia").val(data.telefonoReferencia);
            $("#email").val(data.email);
            $("#idpersona").val(data.idpersona);

        }
    );
}

function eliminar(idpersona) {
    bootbox.confirm("¿Estas seguro de eliminar el Cliente?", function (result) {
        if (result) {
            $.post(
                "../ajax/persona.php?op=eliminar",
                { idpersona: idpersona },
                function (e) {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                }
            );
        }
    });
}


function showButtonsEdit(flag) {
    if (flag) {
        $("#editarImagen").show();
        $("#editarIne").show();
        $("#editarLicencia").show();
        $("#editarTia").show();

        $("#editarAntecedentesPenales").show();
        $("#editarAptitudPsicofisica").show();
        $("#editarComprobanteDomicilio").show();
        $("#editarCurp").show();

    } else {
        $("#editarImagen").hide();
        $("#editarIne").hide();
        $("#editarLicencia").hide();
        $("#editarTia").hide();

        $("#editarAntecedentesPenales").hide();
        $("#editarAptitudPsicofisica").hide();
        $("#editarComprobanteDomicilio").hide();
        $("#editarCurp").hide();
    }
}
init();