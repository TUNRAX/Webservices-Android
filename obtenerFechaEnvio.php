<?php
$idHistorial = $_REQUEST['idHistorial'];



function seleccionar_historial($idHistorial) {
	$mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT fecha_envio FROM `lenappc1_lenyapp`.`historial_envio` where id = ?");
		$stmt->bind_param("i", $idHistorial);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
	}
}

$lista = seleccionar_historial($idHistorial);
$datos["historialFechaEntrega"]=$lista;
echo json_encode($datos);