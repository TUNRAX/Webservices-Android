<?php

$idHistorial = $_REQUEST['idHistorial'];


function seleccionar_validado($idHistorial) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM historial_envio where id = ? ORDER BY ID DESC LIMIT 1");
		$stmt->bind_param("i", $idHistorial);
        $stmt->execute();
		$resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
	}
}

$validado = seleccionar_validado($idHistorial);
$datos["validado"]=$validado;
echo json_encode($datos);
	