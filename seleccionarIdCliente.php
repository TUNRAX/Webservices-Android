<?php

$idUsuario = $_REQUEST['idUsuario'];


function seleccionar_cliente($idUsuario) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
	if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM cliente where id_usuario = ?");
		$stmt->bind_param("i", $idUsuario);
        $stmt->execute();
		$resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
	}
}

$cliente = seleccionar_cliente($idUsuario);
$datos["idCliente"]=$cliente;
echo json_encode($datos);