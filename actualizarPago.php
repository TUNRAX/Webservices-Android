<?php

$idHistorial = $_REQUEST['idHistorial'];
$paga = $_REQUEST['pago'];
$validado = 1;

actualizar_pago($paga, $validado,  $idHistorial);
function actualizar_pago($paga, $validado, $idHistorial) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("UPDATE historial_envio SET `pagado`= ?, `estado`= ? where id = ?");
		$stmt->bind_param("iii", $paga,$validado, $idHistorial);
        $stmt->execute();

	}
}