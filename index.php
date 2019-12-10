<?php
if (!session_id())
    @session_start();
include_once 'conexion.php';

$correo = "";
$contraseña = "";
$error = "";
$rol = 0;

if (isset($_POST['login'])) {
    if (isset($_POST['correo'])) {
        $correo = $_POST['correo'];
    }
    if (isset($_POST['contraseña'])) {
        $contraseña = $_POST['contraseña'];
    }

    $usuario = login($correo, $contraseña);
    if ($usuario != null) {
        $_SESSION['conectado'] = $usuario;
        $rol = $usuario['id_rol'];
        if ($rol == 1)
            header('Location: menu_admin.php');
        else if ($rol == 2) {
            header('Location: menu_usuario.php');
        }
    } else {
        $error = '<div class="alert alert-danger">Usuario o contraseña incorrecto</div>';
    }
}
?>

<!DOCTYPE html>
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

        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/css/style-responsive.css" rel="stylesheet">

        <script src="assets/js/chart-master/Chart.js"></script>
        <style>
            body{
                background-image: url('img/jksajksajksjksajkas.jpg'); 
                background-size: cover;
            }
            .panel{
                top: 50%;
                margin-top: 150px;
                background-color: rgba(255,255,255,0.8);
                box-shadow: 0px 0px 13px 1px rgba(0,0,0,0.75);
            }
            .panel-heading{
                color: color;
            }

            .registro{
                color: black;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid" >

            <form action="index.php" method="post">

                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-login">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-6">
                                    <h1>Login</h1>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group form-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="email" name="correo" class="form-control" placeholder="Correo electronico" required>
                                    </div>
                                    <div class="input-group form-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input type="password" name="contraseña" class="form-control" placeholder="Contraseña" required>
                                    </div>
                                    <?php print $error; ?>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-3">
                                                <input type="submit" name="login" class="form-control btn btn-primary" value="Ingresar">
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-4 registro">
                                                ¿No tienes una cuenta? Registrate <a href="registro.php" >aqui</a>
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
