<?php

ini_set('display_errors', 1);

$idHistorial = $_REQUEST['idHistorial'];
$latitud = $_REQUEST['lat'];
$longitud = $_REQUEST['long'];
$verificacion=verificarCoordenadas($idHistorial);

actualizar_coordenadas($latitud, $longitud, $idHistorial);



function actualizar_coordenadas($latitud, $longitud, $idHistorial) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("UPDATE reparto SET `lat_usu`= ?, `long_usu`= ? where id_historial_envio = ?");
		$stmt->bind_param("ssi", $latitud, $longitud, $idHistorial);
        $stmt->execute();

	}
}

function verificarCoordenadas($idHistorial) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select * from reparto where id_historial_envio = ?");
		$stmt->bind_param("i", $idHistorial);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}