<?php

$idCliente = $_REQUEST['idCliente'];


function seleccionarCliente($idCliente){
	$mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM cliente where id = ?");
		$stmt->bind_param("i", $idCliente);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
	}
}



$obtenerCliente = seleccionarCliente($idCliente);
$datos ["cliente"]= $obtenerCliente;
echo json_encode($datos);