<?php

$idHistorial = $_REQUEST['idHistorial'];

function seleccionar_pago($idHistorial) {
	$coordenadas = array();
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT `pagado` FROM `lenyapp`.`historial_envios` where id = ?");
		$stmt->bind_param("i", $idHistorial);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $coordenadas[] = $fila;
        }
		

    }
	return $coordenadas;
}

$lista = seleccionar_pago($idHistorial);
$datos["pago"]=$lista;
echo json_encode($datos);