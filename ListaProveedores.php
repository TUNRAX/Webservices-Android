<?php

function seleccionar_usuarios_lenyadores() {
    $usuarios = array();
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select id from usuario where activo = 1 AND id_rol = 3");
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $usuarios[] = $fila;
        }
    }
    return $usuarios;

}

function seleccionar_proveedores($id_usuarios) {
    $proveedores = array();
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
	$ids = array_column($id_usuarios, 'id');
	$params = implode(',', array_fill(0, count($ids), '?'));

    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
		$types = "";
        foreach($ids as $value)
            $types .= "i";
        $ids = array_merge(array($types),$ids);
        $stmt = $mysqli->prepare('select * from proveedor where id_usuario IN ('.$params.')');
        $refArray = array();
        foreach($ids as $key => $value) $refArray[$key] = &$ids[$key];
        call_user_func_array(array($stmt, 'bind_param'), $refArray);
		$stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $proveedores[] = $fila;
        }
    }
    return $proveedores;
}




$id_usuarios = array();
$id_usuarios = seleccionar_usuarios_lenyadores();

$ids = array_column($id_usuarios, 'id');
$id_usuario_transformado = implode(',', $ids);

$vendedores = seleccionar_proveedores($id_usuarios, $id_usuario_transformado);
$datos["vendedores"]=$vendedores;
echo json_encode($datos);