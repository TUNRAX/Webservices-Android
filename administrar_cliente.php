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

$clientes = seleccionar_clientes();
$cliente_mostrar = 8;
$filas = count($clientes);
$paginas = $filas / 8;
$paginas = ceil($paginas);

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
          
          
          <?php
            if (!$_GET) {
                header("Location:administrar_cliente.php?pagina=1");
            }

            if ($_GET['pagina'] > $paginas) {
                header("Location:administrar_cliente.php?pagina=" . $paginas . "");
            }
            if ($_GET['pagina'] < $paginas) {
                header("Location:administrar_cliente.php?pagina=1");
            }


            $iniciar = ($_GET['pagina'] - 1) * $cliente_mostrar;

            $clientes_tabla = seleccionar_clientes_li($iniciar, $cliente_mostrar);
            ?>
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
                            <a href="administrar_proveedor.php?pagina=1" >
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
                    <div class="container-fluid" id="contenido">
                        <div class="col-lg-9 main-chart" >
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Rut</th>
                                        <th>Direccion</th>
                                        <th>Fono</th>
                                        <th>Ciudad</th>
                                        
                                    </tr>
                                </thead>
                                <?php
                                foreach ($clientes_tabla as $clientes) {
                                    ?>
                                    <tbody>
                                        <tr>
                                            <td><?= $clientes['nombre'] ?></td>
                                            <td><?= $clientes['apellido'] ?></td>
                                            <td><?= $clientes['rut'] ?></td>
                                            <td><?= $clientes['direccion'] ?></td>
                                            <td><?= $clientes['fono'] ?></td>
                                            <td><?= $clientes['ciudad'] ?></td>

                                            <td>
                                                <a href="editar_cliente.php?cliente=<?= $clientes['id'] ?>" class="btn btn-success">EDITAR</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <?php
                                }
                                ?>

                            </table>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item <?= $_GET['pagina'] <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="administrar_cliente.php?pagina=<?= $_GET['pagina'] - 1 ?>">Anterior</a></li>
                                    <?php for ($i = 0; $i < $paginas; $i++): ?>
                                        <li class="page-item <?= $_GET['pagina'] == $i + 1 ? 'active' : '' ?>">
                                            <a class="page-link" href="administrar_cliente.php?pagina=<?= $i + 1 ?>">
                                                <?= $i + 1 ?>
                                            </a>
                                        </li>
                                    <?php endfor ?>
                                    <li class="page-item  <?= $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>"><a class="page-link" href="administrar_cliente.php?pagina=<?= $_GET['pagina'] + 1 ?>">Siguiente</a></li>
                                </ul>
                            </nav>
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

