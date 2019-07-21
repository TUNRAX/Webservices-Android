<?php
include "conexion.php";

if (!session_id())
    @session_start();

$conectado = null;
$rol = 0;
if (isset($_SESSION['conectado'])) {
    $conectado = $_SESSION['conectado'];
}
$rol = $conectado['id_rol'];
if ($conectado == null) {
    header("Location: index.php");
} else if ($rol == 1) {
    session_destroy();
    header("Location: index.php");
}

$producto = "";
$medida = "";
$precio = 0;
$venta_minima = 0;

if (isset($_POST['guardar'])) {
    if (isset($_POST['producto'])) {
        $producto = $_POST['producto'];
    }
    if (isset($_POST['medida'])) {
        $medida = $_POST['medida'];
    }
    if (isset($_POST['precio'])) {
        $precio = $_POST['precio'];
    }
    if (isset($_POST['venta_minima'])) {
        $venta_minima = $_POST['venta_minima'];
    }

    $id = $conectado['id'];
    $proveedor = seleccionar_proveedor($id);

    if (isset($_FILES['imagen'])) {

        //almacenamos las propiedades de las imagenes
        $tmp_name_array = $_FILES['imagen']['tmp_name'];

        //recorremos el array de imagenes para subirlas al simultaneo
        for ($i = 0; $i < count($tmp_name_array); $i++) {
            $directorio = $_SERVER['DOCUMENT_ROOT'] .'/img_nose/' . $proveedor['id'] . "_" . $i . ".jpg";
			//$directorio = '/img_nose/'
            move_uploaded_file($tmp_name_array[$i], $directorio);
        }
    }

    crear_detalle((int) $precio, (int) $venta_minima, $producto, $medida, $proveedor['id']);
    header("Location: administrar_productos.php");
    //var_dump($precio,$venta_minima,$producto,$medida,$id);
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
                <a href="menu_usuario.php" class="logo"><b>Administracion</b></a>
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
                            <a class="active" href="administrar_productos.php">
                                <i class="fa fa-dashboard"></i>
                                <span>Mis productos</span>
                            </a>
                        </li>
                        <li class="sub-menu">
                            <a href="mis_datos.php" >
                                <i class="fa fa-cogs"></i>
                                <span>Mis datos</span>
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
                            <form action="productos.php" method="POST" enctype="multipart/form-data">


                                <div class="form-group">
                                    Productos:
                                    <select class="form-control" name="producto">
                                        <option>Hualle</option>
                                        <option>Eucalipto</option>
                                        <option>Ulmo</option>
                                        <option>Alamo</option>
                                        <option>Pino</option>
                                        <option>Nativo</option>
                                        <option>Pino</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Medida:
                                    <select class="form-control" name="medida">
                                        <option>Metro</option>
                                        <option>1/2 Metro</option>
                                        <option>1/4 Metro</option>
                                        <option>Saco</option>
                                        <option>Astilla</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Precio unitario:
                                    <input type="number" class="form-control" name="precio" required>
                                </div>
                                <div class="form-group">
                                    Venta minima:
                                    <input type="number" class="form-control" name="venta_minima" required>
                                </div>
                                <div class="form-group">
                                    Fotos:
                                    <input type="file" class="form-control" name="imagen[]" multiple id="imagen"  class="btn btn-default"  required>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="guardar" class="form-control btn btn-primary" value="Guardar">
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
            /*
             $('#proveedores').click(function (e) {
             $.ajax({
             url: "proveedor.php",
             method:"POST",
             dataType: 'html'
             
             }).done(function (respuesta){
             $("#contenido").html(respuesta);
             });
             });*/
        </script>


    </body>
</html>