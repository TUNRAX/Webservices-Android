<?php

$idHistorial = $_REQUEST['idHistorial'];
$tipoDePago = $_REQUEST['tipoDePago'];


actualizar_validado($tipoDePago, $idHistorial);
function actualizar_validado($tipoDePago, $idHistorial) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("UPDATE historial_envio SET `tipo_compra_id`= ? where id = ?");
		$stmt->bind_param("ii", $tipoDePago, $idHistorial);
        $stmt->execute();

	}
}