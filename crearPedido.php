<?php

$idCliente = $_REQUEST['idCliente'];
$idDetalle = $_REQUEST['idDetalle'];
$tipoDeCompra = $_REQUEST['tipoDeCompra'];
$cantidad= $_REQUEST['cantidad'];
$verificacionDefault = 3;
$pagoDefault = 2;



function ingresar_historial($verificacionDefault ,$idCliente,$idDetalle,$tipoDeCompra,$pagoDefault,$cantidad) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("insert into historial_envio (estado,id_cliente,id_detalle_producto,tipo_compra_id,pagado,cantidad,hora,fecha) VALUES (?,?,?,?,?,?,CURRENT_TIME(),CURDATE())");
		$stmt->bind_param("iiiiii", $verificacionDefault, $idCliente, $idDetalle, $tipoDeCompra, $pagoDefault,$cantidad);
        $stmt->execute();
	}
}
	
function seleccionar_id_historial($idCliente) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM historial_envio where id_cliente = ? ORDER BY ID DESC LIMIT 1");
		$stmt->bind_param("i", $idCliente);
        $stmt->execute();
		$resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
	}
}
	
ingresar_historial($verificacionDefault,$idCliente,$idDetalle,$tipoDeCompra,$pagoDefault,$cantidad);
$idHistorial = seleccionar_id_historial($idCliente);
$datos["idHistorial"]=$idHistorial;
echo json_encode($datos);
	