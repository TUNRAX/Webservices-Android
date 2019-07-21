<?php
function seleccionar_proveedores() {
	$idUsuario = $_REQUEST['idUsuario'];
    $proveedores = array();
	$proveedoresSelect = array();
    $mysqli = new mysqli("localhost", "root", "", "lenappc1_lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("SELECT id_proveedor FROM visita where id_usuario = ? GROUP BY id_proveedor HAVING count(*) >= 1");
		$stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $proveedores[] = $fila;
        }
		foreach($proveedores as $prov){
			$stmt2 = $mysqli->prepare("select * from proveedor where id = '".$prov['id_proveedor']."'");
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
