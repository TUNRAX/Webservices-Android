<?php

$idHistorial = $_REQUEST['idHistorial'];

function seleccionar_historial($idHistorial) {
	$coordenadas = array();
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM `lenappc1_lenyapp`.`historial_envio` where id = ?");
		$stmt->bind_param("i", $idHistorial);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $coordenadas[] = $fila;
        }
		

    }
	return $coordenadas;
}

$lista = seleccionar_historial($idHistorial);
$datos["historial"]=$lista;
echo json_encode($datos);