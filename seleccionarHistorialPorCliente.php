<?php
$idUsuario = $_REQUEST['idUsuario'];



function seleccionarIdCliente($idUsuario){
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM cliente WHERE id_usuario = ?");
		$stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}


function seleccionar_historial($idClienteArray) {
    $listaHistorial = array ();
	$mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM `lenappc1_lenyapp`.`historial_envio` where id_cliente = ?");
		$stmt->bind_param("i", $idClienteArray);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $listaHistorial[] = $fila;
        }
		
	return $listaHistorial;
	}
}



$idCliente=seleccionarIdCliente($idUsuario);
$idClienteArray = array_values($idCliente)[0];
$lista = seleccionar_historial($idClienteArray);
$datos["historial"]=$lista;
echo json_encode($datos);