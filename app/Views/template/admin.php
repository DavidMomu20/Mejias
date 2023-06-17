<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin - Hostal Restuarante Mejías</title>

    <!-- Favicons -->
    <link href="<?php echo base_url('assets/img/favicon.png'); ?>" rel="icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Amatic+SC:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap Links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>

    <!-- Templates JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- DataTable Templates -->
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet" />
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.js"></script>
    <script src="<?=base_url('assets/js/responsive.js')?>"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
    <!--
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
        -->

    <!-- Templates CSS -->
    <link rel="stylesheet" href="<?=base_url('assets/css/styles.css')?>" />
    <link rel="stylesheet" href="<?=base_url('assets/css/reservas.css')?>">

    <!-- Select2 Templates -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- My JS Files -->
    <script src="<?=base_url(" assets/js/misFunciones.js")?>" defer></script>

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <!-- <img src="base_url('assets/img/logo-white.png')?>" alt="LogoBlanco"> -->
        <a class="navbar-brand ps-3" href="<?=base_url("admin")?>">Mejías</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?=base_url('admin/micuenta')?>">Mis Datos</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?=site_url('/logout')?>">
                            <div class="sb-nav-link-icon"
                                style="display: inline-flex; justify-content: center; align-items: center; gap: 6%;">
                                <i class="fa-solid fa-power-off" style="color: #ea3939;"></i>
                                Cerrar Sesión
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <?php
                            if (session()->get('logged_in')):
                                if (session()->get("permisos_user")["perm10"] == 1):
                                ?>
                        <div class="sb-sidenav-menu-heading">Cruds</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCruds"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-table"></i></div>
                            Seleccione una tabla
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseCruds" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?=base_url("admin/crud/reservas-mesa")?>">Reservas Mesas</a>
                                <a class="nav-link" href="<?=base_url("admin/crud/reservas-hab")?>">Reservas Habitaciones</a>
                                <a class="nav-link" href="<?=base_url("admin/crud/comandas")?>">Comandas</a>
                                <a class="nav-link" href="<?=base_url("admin")?>">Platos</a>
                                <a class="nav-link" href="<?=base_url("admin/crud/usuarios")?>">Usuarios</a>
                            </nav>
                        </div>
                        <?php
                                endif;
                                if (session()->get("permisos_user")["perm8"] == 1):
                                ?>
                        <div class="sb-sidenav-menu-heading">Comandas</div>
                        <a class="nav-link" href="<?=base_url('admin/comandas')?>">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-scroll"></i></div>
                            Crear nueva comanda
                        </a>
                        <?php
                                endif;
                                if (session()->get("permisos_user")["perm9"] == 1):
                                ?>
                        <div class="sb-sidenav-menu-heading">Reservas</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseReservasPendientes" aria-expanded="false"
                            aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-clock"></i></div>
                            Reservas Pendientes
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseReservasPendientes" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?=base_url("admin/reservas-mesa-pendientes")?>">Mesas</a>
                                <a class="nav-link" href="<?=base_url("admin/reservas-habs-pendientes")?>">Habitaciones</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseReservasConfirmadas" aria-expanded="false"
                            aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-book"></i></div>
                            Reservas Confirmadas
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseReservasConfirmadas" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?=base_url("admin/reservas-mesa-confirmadas")?>">Mesas</a>
                                <a class="nav-link" href="<?=base_url("admin/reservas-habs-confirmadas")?>">Habitaciones</a>
                            </nav>
                        </div>
                        <?php
                                endif;
                            endif;
                            ?>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Sesión Iniciada como:</div>
                    <?=session()->get('full_name')?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <?= $cuerpo ?>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy;
                            <a href="<?=base_url()?>"
                                style="color: blue; font-weight: var(--color-alternative); text-decoration: none;">Hostal
                                Restaurante Mejías</a>
                            2023
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <div class="puntoVerde"></div>
                <strong class="me-auto">Bootstrap</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Hello, world! This is a toast message.
            </div>
        </div>
    </div>

</body>

<!-- Scripts -->
<script src="<?=base_url('assets/js/scripts.js')?>"></script>

</html>