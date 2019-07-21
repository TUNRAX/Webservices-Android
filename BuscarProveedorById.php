<?PHP
$enlace = mysqli_connect("localhost", "root", "", "lenyapp");
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
    $idProveedor = $obj->{'idProveedor'};
	
	$mysqli_query=("select * from proveedor where id = ".$idProveedor."");
  	$result=mysqli_query($enlace,$mysqli_query) or die(mysqli_error());
  
  	$json = array();
  	
	if(mysqli_num_rows($result)){
		while($row=mysqli_fetch_assoc($result)){
		$json['proveedor'][]=$row;
		}
	}
      
  	mysqli_close($enlace);
  	echo json_encode($json);
}
?>

