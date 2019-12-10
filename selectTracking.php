<?php

function seleccionar_coordenadas() {
	$coordenadas = array();
    $mysqli = new mysqli("127.0.0.1", "root", "", "tracking");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT `lat`, `long` FROM `tracking`.`tracking`;");
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $coordenadas[] = $fila;
        }
		

    }
	return $coordenadas;
}

$listaCoordenadas = seleccionar_coordenadas();
$datos["coordenadas"]=$listaCoordenadas;
echo json_encode($datos);