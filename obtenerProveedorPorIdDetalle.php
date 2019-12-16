<?php

$idDetalle = $_REQUEST['idDetalle'];




function seleccionarIdProveedorByIdDetalle($idDetalle){
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

function seleccionarProveedor($idProveedor){
	$mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM `lenappc1_lenyapp`.`proveedor` where id = ?");
		$stmt->bind_param("i", $idProveedor);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
	}
}



$obtenerDetalleProducto = seleccionarIdProveedorByIdDetalle($idDetalle);
$idProveedor = array_values($obtenerDetalleProducto)[4];
$listaProveedor = seleccionarProveedor($idProveedor);
$datos ["proveedor"]= $listaProveedor;
echo json_encode($datos);