<?php

ini_set('display_errors', 1);

$idUsuario = $_REQUEST['idUsuario'];
$titulo = $_REQUEST['titulo'];
$descripcion = $_REQUEST['descripcion'];


insertar_reporte($titulo, $descripcion, $idUsuario);

function insertar_reporte($titulo, $descripcion, $idUsuario) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("insert into reportes (titulo, descripcion, id_usuario) values (?,?,?)");
		$stmt->bind_param("ssi", $titulo, $descripcion, $idUsuario);
        $stmt->execute();
	}
}




