var tabla;

//Funcion que se ejecuta al inicio
function fill()
{
    var params = new URLSearchParams(location.search);
    var fecha = params.get("fecha");
    var destino = params.get("destino");
    var unidad = params.get("unidad");
    var auto = params.get("auto");
    var tipoPago = params.get("tipoPago");
    var numeroTicket = params.get("numeroTicket");
    var totalMxn = params.get("totalMxn");
    var totalUsd = params.get("totalUsd");

    $('#fechaTicket').val(fecha);
    $('#destinoTicket').val(destino);
    $('#unidadTicket').val(unidad);
    $('#autoTicket').val(auto);
    $('#tipopagoTicket').val(tipoPago);
    $('#numeroTicket').val(numeroTicket);
    $('#totalmxnfaTicket').val(totalMxn);
    $('#totalusdTicket').val(totalUsd);
}

init() {
  fill();
}
