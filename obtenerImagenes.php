<?php

$idProveedor = $_REQUEST['idProveedor'];


function seleccionar_detalles($idProveedor) {
	$idSelect = array();
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT id FROM detalle_producto where id_proveedor = ? ");
		$stmt->bind_param("i", $idProveedor);
        $stmt->execute();
		$resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $idSelect[] = $fila;
        }
	}
	return $idSelect;
}


function seleccionar_imagenes($detalles) {
	$nombreSelect = array();
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
	$ids = array_column($detalles, 'id');
	$params = implode(',', array_fill(0, count($ids), '?'));
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
		$types = "";
        foreach($ids as $value)
            $types .= "i";
        $ids = array_merge(array($types),$ids);
        $stmt = $mysqli->prepare('SELECT * FROM img_producto where id_detalle_producto  IN ('.$params.') ');
		$refArray = array();
        foreach($ids as $key => $value) $refArray[$key] = &$ids[$key];
        call_user_func_array(array($stmt, 'bind_param'), $refArray);
        $stmt->execute();
		$resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $nombreSelect[] = $fila;
        }
        return $nombreSelect;
	}
}

$detalles = array();
$detalles = seleccionar_detalles($idProveedor);





$nombresArchivo = seleccionar_imagenes($detalles);
$datos["nombres"]=$nombresArchivo;
echo json_encode($datos);