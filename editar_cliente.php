<?php

if (!session_id())
    @session_start();

include_once 'conexion.php';

$conectado = null;
$rol = 0;
if (isset($_SESSION['conectado'])) {
    $conectado = $_SESSION['conectado'];
}
$rol = $conectado['id_rol'];
if ($conectado == null) {
    header("Location: index.php");
} else if ($rol == 2) {
    session_destroy();
    header("Location: index.php");
}

if (isset($_GET['cliente'])) {
    $id = $_GET['cliente'];
    $cliente = seleccionar_cliente($id);
}

$id = 0;
$nombre = "";
$apellido = "";
$rut = "";
$direccion = "";
$fono = "";
$ciudad = "";

if (isset($_POST['editar'])) {

    if (isset($_POST['id'])) {
        $id = $_POST['id'];
    }
    if (isset($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
    }
    if (isset($_POST['apellido'])) {
        $apellido = $_POST['apellido'];
    }
    if (isset($_POST['rut'])) {
        $rut = $_POST['rut'];
    }
    if (isset($_POST['direccion'])) {
        $direccion = $_POST['direccion'];
    }
    if (isset($_POST['fono'])) {
        $fono = $_POST['fono'];
    }
    if (isset($_POST['ciudad'])) {
        $ciudad = $_POST['ciudad'];
    }
    
    //var_dump($apellido,$ciudad,$direccion,$estado,$fono,$id,$nombre,$rut);
    editar_cliente($nombre, $apellido, $rut, $direccion, $ciudad, $fono, $id);
    //editar_proveedor($nombre, $apellido, $nombre_empresa, $direccion, $fono1, $activo, $fono2, $ciudad, $id);
    header("Location: administrar_cliente.php?pagina=1");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
    </head>

    <body>

        <section id="container" >
            <!-- **********************************************************************************************************************************************************
            TOP BAR CONTENT & NOTIFICATIONS
            *********************************************************************************************************************************************************** -->
            <!--header start-->
            <header class="header black-bg">
                <div class="sidebar-toggle-box">
                    <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
                </div>
                <!--logo start-->
                <a href="menu_admin.php" class="logo"><b>Administracion</b></a>
                <!--logo end-->
                <div class="top-menu">
                    <ul class="nav pull-right top-menu">
                        <li><a class="logout" href="cerrar_sesion.php">Logout</a></li>
                    </ul>
                </div>
            </header>
            <!--header end-->

            <!-- **********************************************************************************************************************************************************
            MAIN SIDEBAR MENU
            *********************************************************************************************************************************************************** -->
            <!--sidebar start-->
            <aside>
                <div id="sidebar"  class="nav-collapse ">
                    <!-- sidebar menu start-->
                    <ul class="sidebar-menu" id="nav-accordion">

                        <li class="sub-menu">
                            <a  href="administrar_proveedor.php?pagina=1" >
                                <i class="fa fa-cogs"></i>
                                <span>Administracion proveedor</span>
                            </a>
                        </li>

                        <li class="sub-menu">
                            <a class="active" href="administrar_cliente.php?pagina=1" >
                                <i class="fa fa-cogs"></i>
                                <span>Administracion Cliente</span>
                            </a>
                        </li>
                      <li class="sub-menu">
                            <a  href="administrar_reportes.php?pagina=1" >
                                <i class="fa fa-cogs"></i>
                                <span>Reportes</span>
                            </a>
                        </li>
                        <!--
                        <li class="sub-menu">
                            <a href="javascript:;" >
                                <i class="fa fa-book"></i>
                                <span>Extra Pages</span>
                            </a>
                            <ul class="sub">
                                <li><a  href="blank.html">Blank Page</a></li>
                                <li><a  href="login.html">Login</a></li>
                                <li><a  href="lock_screen.html">Lock Screen</a></li>
                            </ul>
                        </li>
                        sirve para hacer un boton con sub botones
                        --> 


                    </ul>
                    <!-- sidebar menu end-->
                </div>
            </aside>
            <!--sidebar end-->

            <!-- **********************************************************************************************************************************************************
            MAIN CONTENT
            *********************************************************************************************************************************************************** -->
            <!--main content start-->
            <section id="main-content">
                <section class="wrapper">

                    <div class="row" id="contenido">
                        <div class="col-lg-9 main-chart" >
                            <form action="editar_cliente.php" method="POST">

                                <input type="hidden" name="id" value="<?= $cliente['id'] ?>"/>
                                <div class="form-group">
                                    Nombre:
                                    <input id="nombre" type="text" name="nombre" class="form-control" required value="<?= $cliente['nombre'] ?>">
                                </div>
                                <div class="form-group">
                                    Apellido:
                                    <input id="apellido" type="text" name="apellido" class="form-control" required value="<?= $cliente['apellido'] ?>">
                                </div>
                                <div class="form-group">
                                    Rut:
                                    <input id="rut" type="text" id="rut" name="rut" class="form-control" oninput="checkRut(this)" required value="<?= $cliente['rut'] ?>">
                                </div>
                                <div class="form-group">
                                    Dirección:
                                    <input id="direccion" type="text" name="direccion" class="form-control" required value="<?= $cliente['direccion'] ?>">
                                </div>
                                <div class="form-group">
                                    Ciudad:
                                    <select id="ciudad" required class="form-control" name="ciudad">
                                        <option value=""></option>
                                        <option value="Osorno">Osorno</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Fono:
                                    <input id="fono1" type="number" name="fono" class="form-control" placeholder="+56987654321" required value="<?= $cliente['fono'] ?>">
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="editar" class="form-control btn btn-primary" value="Guardar cambios">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!-- /col-lg-9 END SECTION MIDDLE -->
                    </div>
                </section>
            </section>
        </section>

        <!-- js placed at the end of the document so the pages load faster -->
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/jquery-1.8.3.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
        <script src="assets/js/jquery.sparkline.js"></script>


        <!--common script for all pages-->
        <script src="assets/js/common-scripts.js"></script>

        <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
        <script type="text/javascript" src="assets/js/gritter-conf.js"></script>

        <!--script for this page-->
        <script src="assets/js/sparkline-chart.js"></script>    
        <script src="assets/js/zabuto_calendar.js"></script>	



        <script>
            $(document).ready(function () {
                $("#date-popover").popover({html: true, trigger: "manual"});
                $("#date-popover").hide();
                $("#date-popover").click(function (e) {
                    $(this).hide();
                });

                $("#my-calendar").zabuto_calendar({
                    action: function () {
                        return myDateFunction(this.id, false);
                    },
                    action_nav: function () {
                        return myNavFunction(this.id);
                    },
                    ajax: {
                        url: "show_data.php?action=1",
                        modal: true
                    },
                    legend: [
                        {type: "text", label: "Special event", badge: "00"},
                        {type: "block", label: "Regular event", }
                    ]
                });
            });


            function myNavFunction(id) {
                $("#date-popover").hide();
                var nav = $("#" + id).data("navigation");
                var to = $("#" + id).data("to");
                console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
            }
        </script>


    </body>
</html>