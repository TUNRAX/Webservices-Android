<?php


$validado=$_REQUEST['validado'];
$idHistorial = $_REQUEST['idHistorial'];

actualizar_validado($validado, $idHistorial);
	


function actualizar_validado($validado, $idHistorial) {
    $mysqli = new mysqli("127.0.0.1", "root", "", "lenappc1_lenyapp");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("UPDATE historial_envio SET estado= ? where id = ?");
		$stmt->bind_param("ii", $validado, $idHistorial);
        $stmt->execute();

	}
}