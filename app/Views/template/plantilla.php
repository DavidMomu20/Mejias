<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>
        <?=$titulo?> - Hostal Restaurante Mejías
    </title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="<?php echo base_url('assets/img/favicon.png'); ?>" rel="icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Amatic+SC:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/vendor/aos/aos.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/vendor/glightbox/css/glightbox.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/vendor/swiper/swiper-bundle.min.css'); ?>" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?php echo base_url('assets/css/main.css');?>" rel="stylesheet">

    <!-- Font Awesome Script -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.4.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Select2 Templates -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- DataTable Templates -->
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet" />
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.js"></script>

    <!-- My JS Files -->
    <script src="<?=base_url(" assets/js/misFunciones.js")?>" defer></script>

    <!-- =======================================================
  * Template Name: Yummy
  * Updated: Mar 10 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/yummy-bootstrap-restaurant-website-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">

            <a href="<?=base_url()?>" class="logo d-flex align-items-center me-auto me-lg-0">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img src="<?php echo base_url('assets/img/logo.png');?>" alt="">
                <!-- <h1>Yummy<span>.</span></h1> -->
            </a>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a href="<?=base_url()?>#hero">
                            <?php echo lang('Translate.home'); ?>
                        </a></li>
                    <li><a href="<?=base_url()?>#about">
                            <?php echo lang('Translate.acerca-de'); ?>
                        </a></li>
                    <li><a href="<?=base_url()?>#menu">
                            <?php echo lang('Translate.menu'); ?>
                        </a></li>
                    <li><a href="<?=base_url()?>#events">
                            <?php echo lang('Translate.eventos'); ?>
                        </a></li>
                    <li><a href="<?=base_url()?>#habitaciones">
                            <?php echo lang('Translate.habitaciones'); ?>
                        </a></li>
                    <li><a href="<?=base_url()?>#gallery">
                            <?php echo lang('Translate.galeria'); ?>
                        </a></li>
                    <li><a href="<?=base_url()?>#contact">
                            <?php echo lang('Translate.contacto'); ?>
                        </a></li>
                    <li class="dropdown"><a href="#">
                            <?php echo lang('Translate.idioma'); ?> <i
                                class="bi bi-chevron-down dropdown-indicator"></i>
                        </a>
                        <ul>
                            <li><a href="<?= base_url('lang/es'); ?>" class="language-link"
                                    data-language="es">Español</a></li>
                            <li><a href="<?= base_url('lang/en'); ?>" class="language-link"
                                    data-language="en">English</a></li>
                            <li><a href="<?= base_url('lang/fr'); ?>" class="language-link"
                                    data-language="fr">Français</a></li>
                        </ul>
                    </li>
                </ul>
            </nav><!-- .navbar -->

            <?php
      if (session()->get('logged_in')) {
        ?>
            <a class="btn-book-a-table" href="<?=site_url('/micuenta');?>">
                <?php echo lang('Translate.mi-cuenta'); ?>
            </a>
            <?php
      }
      else {
        ?>
            <a class="btn-book-a-table" data-bs-toggle="modal" data-bs-target="#modalLogin">
                <?php echo lang('Translate.iniciar-sesion'); ?>
            </a>
            <?php
      }
      ?>
            <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
            <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

        </div>
    </header><!-- End Header -->

    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2>
                        <?=$titulo?>
                    </h2>
                    <ol>
                        <li><a href="<?=base_url()?>">Inicio</a></li>
                        <li>
                            <?=$titulo?>
                        </li>
                    </ol>
                </div>

            </div>
        </div><!-- End Breadcrumbs -->

        <section class="sample-page">
            <div class="container" data-aos="fade-up">

                <?= $cuerpo; ?>

            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">

        <div class="container">
            <div class="row gy-3">
                <div class="col-lg-3 col-md-6 d-flex">
                    <i class="bi bi-geo-alt icon"></i>
                    <div>
                        <h4>
                            <?php echo lang('Translate.direccion'); ?>
                        </h4>
                        <p>
                            C. Estación Salinas, 2, 29315 <br>
                            Estación de Salinas - Málaga<br>
                        </p>
                    </div>

                </div>

                <div class="col-lg-3 col-md-6 footer-links d-flex">
                    <i class="bi bi-telephone icon"></i>
                    <div>
                        <h4>
                            <?php echo lang('Translate.reservas'); ?>
                        </h4>
                        <p>
                            <strong>
                                <?php echo lang('Translate.telefono'); ?>:
                            </strong> +34 952 71 45 02<br>
                            <strong>
                                <?php echo lang('Translate.correo'); ?>:
                            </strong> hostalmejias@hotmail.com<br>
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 footer-links d-flex">
                    <i class="bi bi-clock icon"></i>
                    <div>
                        <h4>
                            <?php echo lang('Translate.horario'); ?>
                        </h4>
                        <p>
                            <strong>
                                <?php echo lang('Translate.every-day'); ?>:
                            </strong><br>
                            07:00 - 00:00
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>
                        <?php echo lang('Translate.siguenos'); ?>
                    </h4>
                    <div class="social-links d-flex">
                        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>

            </div>
        </div>

        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>Mejías</span></strong>.
                <?php echo lang('Translate.derechos'); ?>
            </div>
            <div class="credits">
                Designed by David Morales 2ºDAW
            </div>
        </div>

    </footer><!-- End Footer -->
    <!-- End Footer -->

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>

    <!-- Modal -->
    <div class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                </div>
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

    <!-- Vendor JS Files -->
    <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/aos/aos.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/glightbox/js/glightbox.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/purecounter/purecounter_vanilla.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/swiper/swiper-bundle.min.js'); ?>"></script>

    <!-- Template Main JS File -->
    <script src="<?php echo base_url('assets/js/main.js'); ?>"></script>

</body>

</html>