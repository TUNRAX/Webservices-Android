<?php

$idHistorial = $_REQUEST['idHistorial'];

function seleccionar_coordenadas($idHistorial) {
	$coordenadas = array();
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM `lenyapp`.`reparto` where id_historial_envio = ?");
		$stmt->bind_param("i", $idHistorial);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $coordenadas[] = $fila;
        }
		

    }
	return $coordenadas;
}

$listaCoordenadas = seleccionar_coordenadas($idHistorial);
$datos["coordenadas"]=$listaCoordenadas;
echo json_encode($datos);