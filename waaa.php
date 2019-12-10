<?php
$idProveedor = $_REQUEST['id'];


function obtenerIdTipoProducto($idProveedor) {
    $productoSelect = array();
	$mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select tipo_producto_id from detalle_producto where id_proveedor =? ");
        $stmt->bind_param("i",$idProveedor);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $productoSelect[] = $fila;
        }
        return $productoSelect;
    }
}


function obtenerNombreTipoProducto($detalles) {
	$nombreSelect = array();
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
	$ids = array_column($detalles, 'tipo_producto_id');
	
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
		
        $stmt = $mysqli->prepare('select nombre from tipo_producto where id  IN ('.$params.') ');
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
$detalles = obtenerIdTipoProducto($idProveedor);




$nombresArchivo = obtenerNombreTipoProducto($detalles);
$datos["nombres"]=$nombresArchivo;
echo json_encode($datos);