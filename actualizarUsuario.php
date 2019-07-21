<?php

ini_set('display_errors', 1);

$nombre = $_REQUEST['nombre'];
$apellido = $_REQUEST['apellido'];
$direccion = $_REQUEST['direccion'];
$ciudad = $_REQUEST['ciudad'];
$fono = $_REQUEST['fono'];
$contrasenya = $_REQUEST['contrasenya'];
$contrasenyaEncriptada = sha1($contrasenya);
$idUsuario = $_REQUEST['idUsuario'];


actualizar_cliente($nombre, $apellido, $direccion, $ciudad, $fono, $idUsuario);
actualizar_contrasenya($contrasenyaEncriptada, $idUsuario);

function actualizar_cliente($nombre, $apellido, $direccion, $ciudad, $fono, $idUsuario) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("update cliente set nombre = ?, apellido = ?, direccion = ?, ciudad = ?, fono = ? where id_usuario = ?");
		$stmt->bind_param("sssssi", $nombre, $apellido, $direccion, $ciudad, $fono, $idUsuario);
        $stmt->execute();

	}
}

function actualizar_contrasenya($contrasenyaEncriptada, $idUsuario) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
		$stmt = $mysqli->prepare("update usuario set contrasenya = ? where id = ?");
		$stmt->bind_param("si", $contrasenyaEncriptada, $idUsuario);
		$stmt->execute();
		}
    }





