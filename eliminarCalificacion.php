<?php


$idUsuario = $_REQUEST['idUsuario'];
$idProveedor = $_REQUEST['idProveedor'];

eliminarCalificacion($idUsuario, $idProveedor);
$calificacion = contarCalificacion($idProveedor);
editar_proveedor_calificacion($calificacion, $idProveedor);


function eliminarCalificacion($idUsuario, $idProveedor) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("delete from calificacion where id_usuario = ? and id_proveedor = ?");
        $stmt->bind_param("ii", $idUsuario, $idProveedor);
        $stmt->execute();
    }
}
function contarCalificacion($idProveedor) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
		$stmt = $mysqli->prepare("select count(*) as calificacion from calificacion where id_proveedor = ?");
		$stmt->bind_param("i", $idProveedor);
		$stmt->execute();
		$resultados = $stmt->get_result();
		while ($fila = $resultados->fetch_assoc()) {
			return $fila['calificacion'];
		}
    }
}
function editar_proveedor_calificacion($calificacion, $idProveedor) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
		$stmt = $mysqli->prepare("update proveedor set calificacion = ? where id = ?");
		$stmt->bind_param("ii", $calificacion,$idProveedor);
		$stmt->execute();
    }
}
