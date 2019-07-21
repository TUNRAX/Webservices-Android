<?php

ini_set('display_errors', 1);

$idUsuario = $_REQUEST['idUsuario'];

$reportes=buscar_reportes($idUsuario);

$datos["reportes"]=$reportes;
echo json_encode($datos);

function buscar_reportes($idUsuario) {
    $reportesSelect = array();
	$mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select * from reportes where id_usuario = ?");
		$stmt->bind_param("i", $idUsuario);
        $stmt->execute();
		$resultados = $stmt->get_result();
		while ($fila = $resultados->fetch_assoc()) {
			$reportesSelect[] = $fila;
		}
	}
	return $reportesSelect;
}




