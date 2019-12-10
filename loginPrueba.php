<?php



$proveedores=proveedores();
$datos["vendedores"]=$proveedores;
echo json_encode($datos);


function proveedores() {
	$reportesSelect = array();
    $mysqli = new mysqli("localhost", "root", "", "lenyapp");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" .
        $mysqli->connect_errno . ") " .
        $mysqli->connect_error;
    } else {
        $stmt = $mysqli->prepare("select * from proveedor where activo = 1");
        $stmt->execute();
        $resultados = $stmt->get_result();
		while ($fila = $resultados->fetch_assoc()) {
			$reportesSelect[] = $fila;
		}
        return $reportesSelect;
    }
}

