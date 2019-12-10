<?php
function seleccionar_proveedores() {
	$idUsuario = $_REQUEST['idUsuario'];
    $proveedores = array();
	$proveedoresSelect = array();
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select idProveedor from ultimasVisitas where idUsuario = ?");
		$stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $proveedores[] = $fila;
        }
		foreach($proveedores as $prov){
			$stmt2 = $mysqli->prepare("select * from proveedor where id = '".$prov['idProveedor']."'");
			//$stmt2->bind_param("i", $vendedores['idProveedor']);
			$stmt2->execute();
			$resultados = $stmt2->get_result();
			while ($fila = $resultados->fetch_assoc()) {
				$proveedoresSelect[] = $fila;
			}
		}

    }
	return $proveedoresSelect;
}
$listaVendedores = seleccionar_proveedores();
$datos["proveedores"]=$listaVendedores;
echo json_encode($datos);
