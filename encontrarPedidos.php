<?php

ini_set('display_errors', 1);

$id = $_REQUEST['idProv'];
$realIdProveedor = obtenerRealIdProveedorFromUsuario($id);
$realIdProveedorTransformado = array_values($realIdProveedor)[0];
$detalle=obtenerDetalle();
$detalleTransformado=array_values($detalle)[0];
$idProveedor=obtenerIdProveedor($detalleTransformado);
$idHistorial= obtenerIdEnvio();
$idHistorialTransformado = array_values($idHistorial)[0];

$validado = obtenerValidado($idHistorialTransformado);
$datos["validado"]=$validado;
$datos["proveedor"] = $realIdProveedor;
echo json_encode($datos);


function obtenerRealIdProveedorFromUsuario($id) {
    $mysqli = new mysqli("127.0.0.1", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM proveedor where id_usuario = ?");
		$stmt->bind_param("i", $id);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}


function obtenerDetalle( ) {
    $mysqli = new mysqli("127.0.0.1", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT id_detalle_producto FROM historial_envio where estado = 3 ORDER BY ID DESC LIMIT 1");
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}

function obtenerIdEnvio( ) {
    $mysqli = new mysqli("127.0.0.1", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT id FROM historial_envio ORDER BY ID DESC LIMIT 1");
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}

function obtenerIdProveedor($detalleTransformado) {
    $mysqli = new mysqli("127.0.0.1", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT id_proveedor FROM detalle_producto where id = ?");
		$stmt->bind_param("i", $detalleTransformado);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}

function obtenerValidado($idHistorialTransformado) {
    $mysqli = new mysqli("127.0.0.1", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM historial_envio where id = ?");
		$stmt->bind_param("i", $idHistorialTransformado);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}





