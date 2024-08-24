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
    $("#idunidad").val("");
    $("#clave").val("");
    $("#propietario").val("");
    $("#tipo_auto").val("");

}

//funcion mostrar formulario
function mostrarform(flag)
{
    limpiar();

    if(flag)
    {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled",false);
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
                    url: '../ajax/unidad.php?op=listarc',
                    type: "get",
                    dataType:"json",
                    error: function(e) {
                        console.log(e.responseText);
                    }
                },
                "bDestroy": true,
                "iDisplayLength": 50, //Paginacion
                "order": [[0,"desc"]] //Ordenar (Columna, orden)

            })
        .DataTable();
}

//funcion para guardar o editar
function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/unidad.php?op=guardarEditar",
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

function mostrar(idunidad)
{
    $.post(
        "../ajax/unidad.php?op=mostrar",
        {idunidad:idunidad},
        function(data,status)
        {
            data = JSON.parse(data);
            mostrarform(true);

            $("#clave").val(data.clave);
            $("#propietario").val(data.propietario);
            $("#tipo_auto").val(data.tipo_auto);
            $("#idunidad").val(data.idunidad);


        }
    );
}


function eliminar(idunidad)
{
    bootbox.confirm("¿Estas seguro de eliminar unidad?",function(result){
        if(result)
        {
            $.post(
                "../ajax/unidad.php?op=eliminar",
                {idunidad:idunidad},
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
