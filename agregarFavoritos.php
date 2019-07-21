<?php

$enlace = mysqli_connect("localhost", "root", "", "lenappc1_lenyapp");
if (!$enlace) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuracion: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuracion: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
else{
   $json = file_get_contents('php://input');
   $obj = json_decode($json);
   $idUsuario = $obj->{'idUsuario'};
   $idProveedor = $obj->{'idProveedor'};

   try{
       $mysqli_query="Insert INTO favorito (id_usuario,id_proveedor) VALUES (".$idUsuario.",".$idProveedor.")";
       $result=mysqli_query($enlace,$mysqli_query) or die(mysqli_error());
       $json = "";
       if(mysqli_num_rows($result)){
          while ($row=mysqli_fetch_assoc($result)) {
            break;
          }
       }
       echo json_encode($json);
       die;
   }catch(Exception $e){
       var_dump($e);
   }
}