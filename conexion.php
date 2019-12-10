<?php

$servidor = "localhost";
$usuario = "root";
$clave = "";
$basedatos = "lenyapp";

$mysqli = new mysqli($servidor, $usuario, $clave, $basedatos);
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

function cambiarestado($estado, $id) {
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("update proveedor set activo = ? WHERE id = ?");
        $stmt->bind_param("ii", $estado, $id);
        $stmt->execute();
    }
}


function editar_MisDatos($nombre_empresa, $fono1,$fono2, $id) {
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("update proveedor set nombre_empresa = ?, fono1 = ?, fono2 = ? where id = ?");
        $stmt->bind_param("sssi", $nombre_empresa, $fono1, $fono2, $id);
        $stmt->execute();
    }
}

function seleccionar_producto($id) {
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select * from detalle_producto where id_proveedor = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}

function seleccionar_clientes_li($iniciar,$clientes_mostrar) {
    $proveedores = array();
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select * from cliente limit ?,?");
        $stmt->bind_param("ii", $iniciar, $clientes_mostrar);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $proveedores[] = $fila;
        }

        return $proveedores;
    }
}

function seleccionar_reportes_li($iniciar,$clientes_mostrar) {
    $reportes = array();
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select * from reportes limit ?,?");
        $stmt->bind_param("ii", $iniciar, $clientes_mostrar);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $reportes[] = $fila;
        }

        return $reportes;
    }
}

function seleccionar_vendedores_li($iniciar,$clientes_mostrar) {
    $proveedores = array();
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select * from proveedor limit ?,?");
        $stmt->bind_param("ii", $iniciar, $clientes_mostrar);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $proveedores[] = $fila;
        }

        return $proveedores;
    }
}

function seleccionar_usuario($correo) {
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select * from usuario where correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}

function seleccionar_proveedor($id) {
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select * from proveedor where id_usuario = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}

function seleccionar_cliente($id) {
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select * from cliente where id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}

function editar_proveedor($nombre, $apellido,$rut, $nombre_empresa, $direccion, $fono1, $activo, $fono2, $ciudad, $id) {
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("update proveedor set nombre = ?, "
                . "apellido = ?, "
                . "rut = ?, "
                . "nombre_empresa = ?, "
                . "direccion = ?, "
                . "fono1 = ?, "
                . "activo = ?, "
                . "fono2 = ?, "
                . "ciudad = ? "
                . "where id = ?");
        $stmt->bind_param("ssssssissi", $nombre, $apellido,$rut, $nombre_empresa, $direccion, $fono1, $activo, $fono2, $ciudad, $id);
        $stmt->execute();
    }
}

function editar_cliente($nombre, $apellido, $rut, $direccion, $fono, $ciudad, $id) {
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("update cliente set nombre = ?, "
                . "apellido = ?, "
                . "rut = ?, "
                . "direccion = ?, "
                . "fono = ?, "
                . "ciudad = ? "
                . "where id = ?");
        $stmt->bind_param("ssssssi", $nombre, $apellido, $rut, $direccion, $fono, $ciudad,  $id);
        $stmt->execute();
    }
}

function crear_usuario($correo, $contraseña, $rol) {
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("insert into usuario (correo,contrasenya,id_rol) values (?,?,?)");
        $stmt->bind_param("ssi", $correo, $contraseña, $rol);
        $stmt->execute();
    }
}

function crear_vendedor($nombre, $apellido, $nombre_empresa, $rut, $direccion, $fono1, $activo, $fono2, $ciudad, $idUsuario) {
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("insert into proveedor (nombre,apellido,nombre_empresa,rut,direccion,fono1,activo,fono2,ciudad,id_usuario) values (?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssissi", $nombre, $apellido, $nombre_empresa, $rut, $direccion, $fono1, $activo, $fono2, $ciudad, $idUsuario);
        $stmt->execute();
    }
}

function login($correo, $contraseña) {
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select * from usuario where correo = ? AND contrasenya = ? ");
        $stmt->bind_param("ss", $correo, $contraseña);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}

function seleccionar_proveedores() {
    $proveedores = array();
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select * from proveedor");
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $proveedores[] = $fila;
        }

        return $proveedores;
    }
}

function seleccionar_reportes() {
    $reportes = array();
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select * from reportes");
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $reportes[] = $fila;
        }

        return $reportes;
    }
}

function seleccionar_clientes() {
    $proveedores = array();
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select * from cliente");
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $proveedores[] = $fila;
        }

        return $proveedores;
    }
}

function crear_detalle($precio, $venta_minima, $producto, $medida, $id) {
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("update detalle_producto set precio_unitario = ?,venta_minima=?,producto=?,medida=? where id_proveedor= ?");
        $stmt->bind_param("iissi", $precio, $venta_minima, $producto, $medida, $id);
        $stmt->execute();
    }
}

function verificar_existe($rut) {
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select * from proveedor where rut = ?");
        $stmt->bind_param("s", $rut);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}

?>