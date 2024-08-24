<?php
if (strlen(session_id()) < 1)
  session_start();

require_once "../modelos/CorteCaja.php";

$corteCaja = new CorteCaja();

$idusuario = $_SESSION["idusuario"];
$corte_fecha = isset($_POST["corte_fecha"]) ? limpiarCadena($_POST["corte_fecha"]) : "";
$turno = isset($_POST["turno"]) ? limpiarCadena($_POST["turno"]) : "";
$cincuentaCentavos = isset($_POST["cincuentaCentavos"]) ? limpiarCadena($_POST["cincuentaCentavos"]) : "";
$unPeso = isset($_POST["unPeso"]) ? limpiarCadena($_POST["unPeso"]) : "";
$dosPesos = isset($_POST["dosPesos"]) ? limpiarCadena($_POST["dosPesos"]) : "";
$cincoPesos = isset($_POST["cincoPesos"]) ? limpiarCadena($_POST["cincoPesos"]) : "";
$diezPesos = isset($_POST["diezPesos"]) ? limpiarCadena($_POST["diezPesos"]) : "";
$veintePesos = isset($_POST["veintePesos"]) ? limpiarCadena($_POST["veintePesos"]) : "";
$billeteVeinte = isset($_POST["billeteVeinte"]) ? limpiarCadena($_POST["billeteVeinte"]) : "";
$billeteCincuenta = isset($_POST["billeteCincuenta"]) ? limpiarCadena($_POST["billeteCincuenta"]) : "";
$billeteCien = isset($_POST["billeteCien"]) ? limpiarCadena($_POST["billeteCien"]) : "";
$billeteDoscientos = isset($_POST["billeteDoscientos"]) ? limpiarCadena($_POST["billeteDoscientos"]) : "";
$billeteQuinientos = isset($_POST["billeteQuinientos"]) ? limpiarCadena($_POST["billeteQuinientos"]) : "";
$billeteMil = isset($_POST["billeteMil"]) ? limpiarCadena($_POST["billeteMil"]) : "";
$total_pesos = isset($_POST["total_pesos"]) ? limpiarCadena($_POST["total_pesos"]) : "";
$dolarUno = isset($_POST["dolarUno"]) ? limpiarCadena($_POST["dolarUno"]) : "";
$dolarDos = isset($_POST["dolarDos"]) ? limpiarCadena($_POST["dolarDos"]) : "";
$dolarCinco = isset($_POST["dolarCinco"]) ? limpiarCadena($_POST["dolarCinco"]) : "";
$dolarDiez = isset($_POST["dolarDiez"]) ? limpiarCadena($_POST["dolarDiez"]) : "";
$dolarVeinte = isset($_POST["dolarVeinte"]) ? limpiarCadena($_POST["dolarVeinte"]) : "";
$dolarCincuenta = isset($_POST["dolarCincuenta"]) ? limpiarCadena($_POST["dolarCincuenta"]) : "";
$dolarCien = isset($_POST["dolarCien"]) ? limpiarCadena($_POST["dolarCien"]) : "";
$total_dolar = isset($_POST["total_dolar"]) ? limpiarCadena($_POST["total_dolar"]) : "";

switch ($_GET["op"]) {
  case 'guardaryeditar':
    $rspta = $corteCaja->insertar(
      $corte_fecha,
      $idusuario,
      $turno,
      $cincuentaCentavos,
      $unPeso,
      $dosPesos,
      $cincoPesos,
      $diezPesos,
      $veintePesos,
      $billeteVeinte,
      $billeteCincuenta,
      $billeteCien,
      $billeteDoscientos,
      $billeteQuinientos,
      $billeteMil,
      $total_pesos,
      $dolarUno,
      $dolarDos,
      $dolarCinco,
      $dolarDiez,
      $dolarVeinte,
      $dolarCincuenta,
      $dolarCien,
      $total_dolar
    );
    echo $rspta ? "Corte de caja registrado" : "No se pudieron registrar todos los datos de la caja";
    break;

  case 'listar':
    $rspta = $corteCaja->listar();
    $data = array();
    while ($reg = $rspta->fetch_object()) {
      $data[] = array(
        "0" => $reg->corte_fecha,
        "1" => 'COR0' . $reg->idcorte,
        "2" => $reg->nombre,
        "3" => $reg->turno,
        "4" => $reg->cincuentaCentavos,
        "5" => $reg->unPeso,
        "6" => $reg->dosPesos,
        "7" => $reg->cincoPesos,
        "8" => $reg->diezPesos,
        "9" => $reg->veintePesos,
        "10" => $reg->billeteVeinte,
        "11" => $reg->billeteCincuenta,
        "12" => $reg->billeteCien,
        "13" => $reg->billeteDoscientos,
        "14" => $reg->billeteQuinientos,
        "15" => $reg->billeteMil,
        "16" => $reg->total_pesos,
        "17" => $reg->dolarUno,
        "18" => $reg->dolarDos,
        "19" => $reg->dolarCinco,
        "20" => $reg->dolarDiez,
        "21" => $reg->dolarVeinte,
        "22" => $reg->dolarCincuenta,
        "23" => $reg->dolarCien,
        "24" => $reg->total_dolar
      );
    }
    $results = array(
      "sEcho" => 1,
      //Información para el datatables
      "iTotalRecords" => count($data),
      //enviamos el total registros al datatable
      "iTotalDisplayRecords" => count($data),
      //enviamos el total registros a visualizar
      "aaData" => $data
    );
    echo json_encode($results);

    break;

  case 'getUsuario':
    require_once "../modelos/Usuario.php";
    $usuario = new Usuario();

    $rspta = $usuario->getNombreUser($idusuario);

		while ($reg = $rspta->fetch_object()) {
			echo $reg->nombre;
		}
    break;
}


//getUsuario
?>