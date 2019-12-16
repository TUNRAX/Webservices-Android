<?php

$idHistorial = $_REQUEST['idHistorial'];
$fechaEnvio = $_REQUEST['fechaEnvio'];
$validado = 6;

actualizar_fecha_estado($fechaEnvio, $validado,  $idHistorial);
function actualizar_fecha_estado($fechaEnvio, $validado,  $idHistorial) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("UPDATE historial_envio SET `fecha_envio`= ?, `estado`= ? where id = ?");
		$stmt->bind_param("sii", $fechaEnvio,$validado, $idHistorial);
        $stmt->execute();

	}
}
