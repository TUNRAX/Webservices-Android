<?php

$idUsuario = $_REQUEST['idUsuario'];
$idProveedor = $_REQUEST['idProveedor'];


$calificacion=verificarCalificacion($idUsuario, $idProveedor);
$datos["calificacion"]=$calificacion;
echo json_encode($datos);


function verificarCalificacion($idUsuario, $idProveedor) {
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select * from calificacion where id_usuario = ? and id_proveedor = ?");
        $stmt->bind_param("ii", $idUsuario, $idProveedor);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}

