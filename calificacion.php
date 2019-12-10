<?php

ini_set('display_errors', 1);

$idUsuario = $_REQUEST['idUsuario'];
$idProveedor = $_REQUEST['idProveedor'];


insertar_calificacion($idUsuario, $idProveedor);
$calificacion = contarCalificacion($idProveedor);
editar_proveedor_calificacion($calificacion, $idProveedor);

function insertar_calificacion($idUsuario, $idProveedor) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("insert into calificacion (id_usuario,id_proveedor) values (?,?)");
		$stmt->bind_param("ii", $idUsuario, $idProveedor);
        $stmt->execute();
	}
}

function contarCalificacion($idProveedor) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
		$stmt = $mysqli->prepare("select count(*) as calificacion from calificacion where id_proveedor = ?");
		$stmt->bind_param("i", $idProveedor);
		$stmt->execute();
		$resultados = $stmt->get_result();
		while ($fila = $resultados->fetch_assoc()) {
			return $fila['calificacion'];
		}
    }
}

function editar_proveedor_calificacion($calificacion, $idProveedor) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
		$stmt = $mysqli->prepare("update proveedor set calificacion = ? where id = ?");
		$stmt->bind_param("ii", $calificacion,$idProveedor);
		$stmt->execute();
    }
}






