<?php

ini_set('display_errors', 1);

$idUsuario = $_REQUEST['idUsuario'];



$cliente=buscar_datos_usuario($idUsuario);
$usuario = seleccionar_usuario($idUsuario);

$datos["cliente"] = $cliente;
$datos["usuario"]=$usuario;
echo json_encode($datos);

function buscar_datos_usuario($idUsuario) {
	$clienteSelect = array();
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select * from cliente where id_usuario = ?");
		$stmt->bind_param("i", $idUsuario);
        $stmt->execute();
		$resultados = $stmt->get_result();
				while ($fila = $resultados->fetch_assoc()) {
			$clienteSelect[] = $fila;
		}
	}
	return $clienteSelect;
}

function seleccionar_usuario($idUsuario) {
	$clienteSelect = array();
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
		$stmt = $mysqli->prepare("select * from usuario where id = ?");
		$stmt->bind_param("i", $idUsuario);
		$stmt->execute();
		$resultados = $stmt->get_result();
		while ($fila = $resultados->fetch_assoc()) {
			$clienteSelect[] = $fila;
		}
    }
	return $clienteSelect;
}







