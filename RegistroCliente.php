<?php

$nombre = $_REQUEST['nombre'];
$apellido = $_REQUEST['apellido'];
$rut = $_REQUEST['rut'];
$direccion = $_REQUEST['direccion'];
$fono = $_REQUEST['fono'];
$ciudad = $_REQUEST['ciudad'];  
$correo = $_REQUEST['correo'];
$contrasenya = $_REQUEST['contrasenya'];
$contrasenyaEncriptada = sha1($contrasenya);
$activo = 1;
$rol = 2;


$servidor = "localhost";
$usuario = "root";
$clave = "";
$basedatos = "lenappc1_lenyapp";

$mysqli = new mysqli($servidor, $usuario, $clave, $basedatos);

if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else {
    //usuario
    $stmt = $mysqli->prepare("insert into usuario (email,contrasenya,id_rol,activo) values (?,?,?,?)");
    $stmt->bind_param("ssii", $correo, $contrasenyaEncriptada, $rol, $activo);
    $stmt->execute();
    $id = $mysqli->insert_id;
    
    //cliente
    
    $stmt = $mysqli->prepare("insert into cliente (nombre,apellido,rut,direccion,fono,ciudad,id_usuario) values (?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssi", $nombre, $apellido, $rut, $direccion, $fono, $ciudad, $id);
    $stmt->execute();
    
    $stmt = $mysqli->prepare("select * from cliente where id_usuario = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultados = $stmt->get_result(); 
    $datos = array();
    foreach ($resultados as $row) {
        $datos[]=$row;
    }
    echo json_encode($datos);
}