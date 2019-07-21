<?php
include_once 'conexion.php';
$nombre = "";
$apellido = "";
$nombre_empresa = "";
$rut = "";
$direccion = "";
$ciudad = "";
$fono1 = "";
$fono2 = "";
$correo = "";
$contraseña = "";
$rep_contraseña = "";
$error = "";
$error_clave = "";

if (isset($_POST['registro'])) {
    if (isset($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
    }
    if (isset($_POST['apellido'])) {
        $apellido = $_POST['apellido'];
    }
    if (isset($_POST['nombre_empresa'])) {
        $nombre_empresa = $_POST['nombre_empresa'];
    }
    if (isset($_POST['rut'])) {
        $rut = $_POST['rut'];
    }
    if (isset($_POST['direccion'])) {
        $direccion = $_POST['direccion'];
    }
    if (isset($_POST['ciudad'])) {
        $ciudad = $_POST['ciudad'];
    }
    if (isset($_POST['fono1'])) {
        $fono1 = $_POST['fono1'];
    }
    if (isset($_POST['fono2'])) {
        $fono2 = $_POST['fono2'];
    }
    if (isset($_POST['correo'])) {
        $correo = $_POST['correo'];
    }
    if (isset($_POST['contraseña'])) {
        $contraseña = $_POST['contraseña'];
    }
    if (isset($_POST['rep_contraseña'])) {
        $rep_contraseña = $_POST['rep_contraseña'];
    }

    $proveedor = verificar_existe($rut);

    if ($proveedor == null) {
        if ($contraseña == $rep_contraseña) {
            $rol = 2;
            $activo = 1;
            crear_usuario($correo, $contraseña, $rol);
            $usuario_nuevo = seleccionar_usuario($correo);
            crear_vendedor($nombre, $apellido, $nombre_empresa, $rut, $direccion, $fono1, $activo, $fono2, $ciudad, $usuario_nuevo['id']);

            header("Location: index.php");
        } else {
            $error_clave = '<div class="alert alert-danger">Contraseñas no coinciden</div>';
        }
    } else {
        $error = '<div class="alert alert-danger">Existe un registro asociado a ese rut</div>';
    }
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Dashboard">
        <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

        <title>Administracion</title>

        <link href="assets/css/bootstrap.css" rel="stylesheet">

        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
        <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
        <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">    
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/css/style-responsive.css" rel="stylesheet">
        <script src="assets/js/jquery-1.8.3.min.js"></script>
        <script src="assets/js/chart-master/Chart.js"></script>
        <script>
            function checkRut(rut) {
                var valor = rut.value.replace('.', '');
                valor = valor.replace('-', '');

                cuerpo = valor.slice(0, -1);
                dv = valor.slice(-1).toUpperCase();

                rut.value = cuerpo + '-' + dv

                if (cuerpo.length < 7) {
                    rut.setCustomValidity("RUT Incompleto");
                    return false;
                }

                suma = 0;
                multiplo = 2;

                for (i = 1; i <= cuerpo.length; i++) {
                    index = multiplo * valor.charAt(cuerpo.length - i);
                    suma = suma + index;
                    if (multiplo < 7) {
                        multiplo = multiplo + 1;
                    } else {
                        multiplo = 2;
                    }
                }

                dvEsperado = 11 - (suma % 11);

                dv = (dv == 'K') ? 10 : dv;
                dv = (dv == 0) ? 11 : dv;

                if (dvEsperado != dv) {
                    rut.setCustomValidity("RUT Inválido");
                    return false;
                }

                rut.setCustomValidity('');
            }
        </script>
        <style>
            body{
                background-image: url('img/jksajksajksjksajkas.jpg'); 
                background-size: cover;
            }
            .panel{
                top: 50%;
                box-shadow: 0px 0px 13px 1px rgba(0,0,0,0.75);
            }
        </style>
    </head>


   <body>
        <div class="container">
            <form action="registro.php" method="post" id="registro"> 
                <div class="row" style="margin-top:100px">
                    <div class="col-md-6 ">
                        <div id="registro1" class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Datos personales</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            Nombre:
                                            <input id="nombre" value="<?= isset($_POST['registro']) ? $nombre : "" ?>" maxlength="45" type="text" name="nombre" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            Apellido:
                                            <input id="apellido" value="<?= isset($_POST['registro']) ? $apellido : "" ?>" maxlength="45" type="text" name="apellido" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            Nombre empresa:
                                            <input id="nombre_empresa" value="<?= isset($_POST['registro']) ? $nombre_empresa : "" ?>" maxlength="45" type="text" name="nombre_empresa" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            Rut:
                                            <input id="rut" type="text" value="<?= isset($_POST['registro']) ? $rut : "" ?>" id="rut" name="rut" class="form-control" oninput="checkRut(this)" required>

                                        </div>
                                    </div>
                                    <?php print $error; ?>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            Dirección:
                                            <input id="direccion" value="<?= isset($_POST['registro']) ? $direccion : "" ?>" maxlength="150" type="text" name="direccion" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            Ciudad:
                                            <select id="ciudad" required class="form-control" name="ciudad">
                                                <option></option>
                                                <option>Osorno</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            Fono:
                                            <input id="fono1" value="<?= isset($_POST['registro']) ? $fono1 : "" ?>" type="text" maxlength="12" name="fono1" class="form-control" placeholder="+56987654321" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            Fono (opcional):
                                            <input id="fono2" value="<?= isset($_POST['registro']) ? $fono2 : "" ?>" type="text" maxlength="12" name="fono2" class="form-control" placeholder="+56987654321" >
                                        </div>
                                    </div>
                                </div>                        
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6"> 
                        <div id="registro2" class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Datos de usuario</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            Correo:
                                            <input id="email" value="<?= isset($_POST['registro']) ? $correo : "" ?>" maxlength="100" type="email" name="correo" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            Contraseña:
                                            <input id="contraseña" value="<?= isset($_POST['registro']) ? $contraseña : "" ?>" maxlength="20" id="clave1" type="password" name="contraseña" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            Repetir contraseña:
                                            <input id="rep_contraseña" value="<?= isset($_POST['registro']) ? $rep_contraseña : "" ?>" maxlength="20" id="clave2" type="password" name="rep_contraseña" class="form-control" required>
                                        </div>
                                        <?php print $error_clave; ?>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-offset-3">
                                                    <input onclick="Alerta()" type="submit" name="registro" class="form-control btn btn-primary" value="Registrar">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
