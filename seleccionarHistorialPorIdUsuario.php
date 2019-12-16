<?php
$idUsuario = $_REQUEST['idUsuario'];



function seleccionarIdProveedor($idUsuario){
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM proveedor WHERE id_usuario = ?");
		$stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}


function seleccionar_detalles($idProveedorArray) {
    $listaHistorial = array ();
	$mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT id FROM detalle_producto where id_proveedor = ?");
		$stmt->bind_param("i", $idProveedorArray);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $listaHistorial[] = $fila;
        }
		
	return $listaHistorial;
	}
}

function seleccionar_historial($detalles) {
    $listaHistorial = array ();
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

        $stmt = $mysqli->prepare('SELECT * FROM `lenappc1_lenyapp`.`historial_envio` where estado = 3 OR estado = 4 OR estado = 6 OR estado = 7 and id_detalle_producto IN ('.$params.')');
		$refArray = array();
        foreach($ids as $key => $value) $refArray[$key] = &$ids[$key];
        call_user_func_array(array($stmt, 'bind_param'), $refArray);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $listaHistorial[] = $fila;
        }
		
	return $listaHistorial;
	}
}

$idProveedor=seleccionarIdProveedor($idUsuario);
$idProveedorArray = array_values($idProveedor)[0];
$detalles = array();
$detalles = seleccionar_detalles($idProveedorArray);
$historialSeleccionado = seleccionar_historial($detalles);
$datos["historial"]=$historialSeleccionado;
echo json_encode($datos);