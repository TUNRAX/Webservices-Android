<?php

$idCliente = $_REQUEST['idCliente'];
$idDetalle = $_REQUEST['idDetalle'];
$verificacionDefault = 3;

ingresar_historial($verificacionDefault,$idCliente,$idDetalle);

function ingresar_historial($verificacionDefault,$idCliente,$idDetalle) {
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("insert into historial_envios (validado,id_cliente,id_detalle_producto,fecha) VALUES (?,?,?,NOW())");
		$stmt->bind_param("iii", $verificacionDefault, $idCliente, $idDetalle);
        $stmt->execute();
	}
}