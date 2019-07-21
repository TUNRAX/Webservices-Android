<?php

ini_set('display_errors', 1);

$idHistorial = $_REQUEST['idHistorial'];
$idProveedor = $_REQUEST['idProv'];
$latitud = $_REQUEST['lat'];
$longitud = $_REQUEST['long'];
$verificacion=verificarCoordenadas($idHistorial);

if($verificacion  === NULL){
	insertar_coordenadas($idHistorial, $idProveedor, $latitud, $longitud);
}else{
	actualizar_coordenadas($latitud, $longitud, $idHistorial);
}





function insertar_coordenadas($idHistorial, $idProveedor, $latitud, $longitud) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("INSERT INTO `lenappc1_lenyapp`.`reparto` (`id_historial_envio`, `id_proveedor`, `lat`, `long`) VALUES (?, ?, ?, ?);");
		$stmt->bind_param("iiss", $idHistorial, $idProveedor, $latitud, $longitud);
        $stmt->execute();
	}
}

function actualizar_coordenadas($latitud, $longitud, $idHistorial) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("UPDATE reparto SET `lat`= ?, `long`= ? where id_historial_envio = ?");
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
