var tabla;

//Funcion que se ejecuta al inicio
function init()
{
    mostrarform(false);
    listar();

    $("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);
    })
}

//funcion limpiar
function limpiar()
{
    $("#ruta_direccion").val("");
    $("#ruta_precio").val("");

}

//funcion mostrar formulario
function mostrarform(flag)
{
    limpiar();

    if(flag)
    {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardarRuta").prop("disabled",false);
        $("#btnagregarRuta").hide();
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregarRuta").show();
    }
}

//Funcion cancelarform
function cancelarform()
{
    limpiar();
    mostrarform(false);
}

//Funcion listar
function listar()
{
    tabla = $('#tblistado')
        .dataTable(
            {
                "aProcessing":true, //Activamos el procesamiento del datatables
                "aServerSide":true, //Paginacion y filtrado realizados por el servidor
                dom: "Bfrtip", //Definimos los elementos del control de tabla
                buttons:[
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdf'
                ],
                "ajax":{
                    url: '../ajax/ruta.php?op=listarc',
                    type: "get",
                    dataType:"json",
                    error: function(e) {
                        console.log(e.responseText);
                    }
                },
                "bDestroy": true,
                "iDisplayLength": 5, //Paginacion
                "order": [[0,"desc"]] //Ordenar (Columna, orden)

            })
        .DataTable();
}

//funcion para guardar o editar
function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarRuta").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/ruta.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos)
        {
            //console.log("succes");
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        },
        error: function(error)
        {
            console.log("error: " + error);
        }
    });

    limpiar();
}

function mostrar(idruta)
{
    $.post(
        "../ajax/ruta.php?op=mostrar",
        {idruta:idruta},
        function(data,status)
        {
            data = JSON.parse(data);
            mostrarform(true);

            $("#ruta_direccion").val(data.ruta_direccion);
            $("#ruta_precio").val(data.ruta_precio);

        }
    );
}


function eliminar(idruta)
{
    bootbox.confirm("¿Estas seguro de eliminar Ruta?",function(result){
        if(result)
        {
            $.post(
                "../ajax/ruta.php?op=eliminar",
                {idruta:idruta},
                function(e)
                {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                }
            );
        }
    });
}

init();
