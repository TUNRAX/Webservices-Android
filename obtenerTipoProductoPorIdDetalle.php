<?php

$idDetalle = $_REQUEST['idDetalle'];

function obtenerDetalle($idDetalle){
	$mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM `lenappc1_lenyapp`.`detalle_producto` where id = ?");
		$stmt->bind_param("i", $idDetalle);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
	}
}

function obtenerProducto($idTipoProducto) {
	$mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select * from tipo_producto where id = ? ");
        $stmt->bind_param("i",$idTipoProducto);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
	}
}

$obtenerDetalleProducto = obtenerDetalle($idDetalle);
$idTipoProducto = array_values($obtenerDetalleProducto)[5];
$ProductoObtenido = obtenerProducto($idTipoProducto);
$datos["producto"]=$ProductoObtenido;
echo json_encode($datos);