<?php

$idProveedor = $_REQUEST['id'];



$productos=obtenerProductos($idProveedor);
$datos["productos"]=$productos;
echo json_encode($datos);


function obtenerProductos($idProveedor) {
    $productoSelect = array();
	$mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select * from detalle_producto where id_proveedor =? ");
        $stmt->bind_param("i",$idProveedor);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $productoSelect[] = $fila;
        }
        return $productoSelect;
    }
}

