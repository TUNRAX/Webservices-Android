<?php

$correo = $_REQUEST['correo'];
$contrasenya = $_REQUEST['contrasenya'];
$contrasenyaEncriptada = sha1($contrasenya);


$check = comprobar_rol($correo, $contrasenyaEncriptada);

$datos= $check;
echo json_encode($datos);

function comprobar_rol($correo, $contrasenyaEncriptada) {
	$checkeado = array();
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select id_rol from usuario where email = ? and contrasenya = ?");
		$stmt->bind_param("ss", $correo, $contrasenyaEncriptada);
        $stmt->execute();
		$resultados = $stmt->get_result();
		while ($fila = $resultados->fetch_assoc()) {
			$checkeado[] = $fila;
		}
	}
	return $checkeado;
}