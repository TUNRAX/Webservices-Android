<?PHP
$enlace = mysqli_connect("localhost", "root", "", "lenappc1_lenyapp");
mysqli_set_charset($enlace,"utf8");
if (!$enlace) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuracion: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuracion: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
else{
   	
    $json = file_get_contents('php://input');
    $obj = json_decode($json);
    $id = $obj->{'id'};

  
	$mysqli_query=("select * from detalle_producto where id_proveedor =".$id." ");
  	$result=mysqli_query($enlace,$mysqli_query) or die(mysqli_error());
  
  	$json = array();
  	
	if(mysqli_num_rows($result)){
		while($row=mysqli_fetch_assoc($result)){
		$json['lenya'][]=$row;
		}
	}
      
  	mysqli_close($enlace);
  	echo json_encode($json);
}
?>











$id = $_REQUEST['id'];

$servidor = "shareddb-i.hosting.stackcp.net";
$usuario = "lenyapp-3335ba15";
$clave = "Lena1234";
$basedatos = "lenyapp-3335ba15";

$mysqli = new mysqli($servidor, $usuario, $clave, $basedatos);

if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else {
    $stmt = $mysqli->prepare("select * from cliente where id_usuario = ? ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultados = $stmt->get_result(); 
    $datos = array();
    foreach ($resultados as $row) {
        $datos["cliente"]=$row;
    }
    echo json_encode($datos);
}