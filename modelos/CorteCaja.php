<?php
//Incluímos inicialmente la conexión a la base de datos
require '../config/conexion.php';

Class CorteCaja
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($corte_fecha,$idusuario,$turno,$cincuentaCentavos,$unPeso,$dosPesos,$cincoPesos,$diezPesos,$veintePesos,$billeteVeinte,$billeteCincuenta,
	$billeteCien,$billeteDoscientos,$billeteQuinientos,$billeteMil,$total_pesos,$dolarUno,$dolarDos,$dolarCinco,$dolarDiez,$dolarVeinte,$dolarCincuenta,$dolarCien,$total_dolar)
	{
		$sql="INSERT INTO corte (
			corte_fecha,idusuario,turno,cincuentaCentavos,unPeso,dosPesos,cincoPesos,diezPesos,veintePesos,billeteVeinte,billeteCincuenta,
			billeteCien,billeteDoscientos,billeteQuinientos,billeteMil,total_pesos,dolarUno,dolarDos,dolarCinco,dolarDiez,dolarVeinte,dolarCincuenta,dolarCien,total_dolar
				)
				VALUES (
					'$corte_fecha','$idusuario','$turno','$cincuentaCentavos','$unPeso','$dosPesos','$cincoPesos','$diezPesos','$veintePesos','$billeteVeinte','$billeteCincuenta',
					'$billeteCien','$billeteDoscientos','$billeteQuinientos','$billeteMil','$total_pesos','$dolarUno','$dolarDos','$dolarCinco','$dolarDiez','$dolarVeinte','$dolarCincuenta','$dolarCien','$total_dolar')";

		$idventanew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		return $sw;
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idventa)
	{
		$sql="SELECT
					v.idventa,
					DATE(v.fecha_hora) as fecha,
					uni.clave,
					p.nombre as cliente,
					u.idusuario,
					u.nombre as usuario,
					v.tipo_comprobante,
					v.serie_comprobante,
					v.num_comprobante,
					v.total_venta,
					v.impuesto,
					v.estado
			    FROM venta v
				INNER JOIN persona p
				ON v.idcliente=p.idpersona
				INNER JOIN usuario u
				ON v.idusuario=u.idusuario
				INNER JOIN unidad uni ON uni.idunidad=v.unidad";

		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idventa)
	{
		$sql="SELECT
				dv.idventa,
				dv.idarticulo,
				a.nombre,
				dv.cantidad,
				dv.precio_venta,
				dv.descuento,
				(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal
				FROM detalle_venta dv
				inner join articulo a
				on dv.idarticulo=a.idarticulo
				where dv.idventa='$idventa'";

		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros

	public function listar()
	{
		$sql= "SELECT
		co.idcorte as corte,
		co.idcorte,
		co.corte_fecha,
		us.nombre,
		co.turno,
		co.cincuentaCentavos,
		co.unPeso,
		co.dosPesos,
		co.cincoPesos,
		co.diezPesos,
		co.veintePesos,
		co.billeteVeinte,
		co.billeteCincuenta,
		co.billeteCien,
		co.billeteDoscientos,
		co.billeteQuinientos,
		co.billeteMil,
		co.total_pesos,
		co.dolarUno,
		co.dolarDos,
		co.dolarCinco,
		co.dolarDiez,
		co.dolarVeinte,
		co.dolarCincuenta,
		co.dolarCien,
		co.total_dolar
		FROM corte co
		INNER JOIN usuario us
		ON us.idusuario = co.idusuario ORDER BY co.idcorte DESC LIMIT 100;";

		return ejecutarConsulta($sql);
	}

	public function ventaDetalle($idventa)
	{
		$sql = "SELECT
					a.nombre as articulo,
					a.codigo,
					d.cantidad,
					d.precio_venta,
					d.descuento,
					(d.cantidad*d.precio_venta-d.descuento) as subtotal
				FROM
					detalle_venta d
				INNER JOIN
					articulo a
				ON
					d.idarticulo = a.idarticulo
				WHERE
					d.idventa = '$idventa'";

		return ejecutarConsulta($sql);
	}
}
?>
