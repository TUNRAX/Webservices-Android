<?php

ini_set('display_errors', 1);

$latitud = $_REQUEST['lat'];
$longitud = $_REQUEST['long'];
$verificacion=verificarCoordenadas($latitud, $longitud);

if($verificacion  === NULL){
	insertar_coordenadas($latitud, $longitud);
}else{
	actualizar_coordenadas($latitud, $longitud);
}





function insertar_coordenadas($latitud, $longitud) {
    $mysqli = new mysqli("127.0.0.1", "root", "", "tracking");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("INSERT INTO `tracking`.`tracking` (`lat`, `long`) VALUES (?, ?);");
		$stmt->bind_param("ss", $latitud, $longitud);
        $stmt->execute();
	}
}

function actualizar_coordenadas($latitud, $longitud) {
    $mysqli = new mysqli("127.0.0.1", "root", "", "tracking");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("UPDATE `tracking`.`tracking` SET `lat`= ?, `long`= ?;");
		$stmt->bind_param("ss", $latitud, $longitud);
        $stmt->execute();

	}
}

function verificarCoordenadas($latitud, $longitud) {
    $mysqli = new mysqli("127.0.0.1", "root", "", "tracking");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select * from tracking");
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}





