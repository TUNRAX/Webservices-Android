<?php


ini_set('display_errors', 1);

$id = $_REQUEST['idUsuario'];
$realIdCliente = obtenerRealIdClienteFromUsuario($id);
$realIdClienteTransformado = array_values($realIdCliente)[0];
$detalle=obtenerDetalle($realIdClienteTransformado);
$detalleTransformado=array_values($detalle)[0];
$precio = obtenerPrecio($detalleTransformado);
$pedido = obtenerPedidoCliente($realIdClienteTransformado);
$datos["historial"]=$pedido;
$datos["precio"]=$precio;
echo json_encode($datos);

function obtenerRealIdClienteFromUsuario($id) {
    $mysqli = new mysqli("127.0.0.1", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM cliente where id_usuario = ?");
		$stmt->bind_param("i", $id);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}

function obtenerPrecio($detalleTransformado) {
    $mysqli = new mysqli("127.0.0.1", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM detalle_producto where id = ?");
		$stmt->bind_param("i", $detalleTransformado);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}

function obtenerDetalle($realIdClienteTransformado) {
    $mysqli = new mysqli("127.0.0.1", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT id_detalle_producto FROM historial_envio where estado = 5 and id_cliente = ? ORDER BY ID DESC LIMIT 1");
		$stmt->bind_param("i", $realIdClienteTransformado);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}

function obtenerPedidoCliente($realIdClienteTransformado) {
    $mysqli = new mysqli("127.0.0.1", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM historial_envio where estado = 5 and id_cliente = ? ORDER BY ID DESC LIMIT 1");
		$stmt->bind_param("i", $realIdClienteTransformado);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}