<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Hostal Restaurante Mejías</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="<?php echo base_url('assets/img/favicon.png')?>" rel="icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Amatic+SC:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/vendor/aos/aos.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/vendor/glightbox/css/glightbox.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/vendor/swiper/swiper-bundle.min.css'); ?>" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?php echo base_url('assets/css/main.css'); ?>" rel="stylesheet">

    <script src="<?=base_url('assets/js/misFunciones.js')?>" defer></script>

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">

            <a href="<?=base_url()?>" class="logo d-flex align-items-center me-auto me-lg-0">
                <img src="<?php echo base_url('assets/img/logo.png'); ?>" alt="">
            </a>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a href="#hero">
                            <?php echo lang('Translate.home'); ?>
                        </a></li>
                    <li><a href="#about">
                            <?php echo lang('Translate.acerca-de'); ?>
                        </a></li>
                    <li><a href="#menu">
                            <?php echo lang('Translate.menu'); ?>
                        </a></li>
                    <li><a href="#events">
                            <?php echo lang('Translate.eventos'); ?>
                        </a></li>
                    <li><a href="#habitaciones">
                            <?php echo lang('Translate.habitaciones'); ?>
                        </a></li>
                    <li><a href="#gallery">
                            <?php echo lang('Translate.galeria'); ?>
                        </a></li>
                    <li><a href="#contact">
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

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="hero d-flex align-items-center section-bg">
        <div class="container">
            <div class="row justify-content-between gy-5">
                <div
                    class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start">
                    <h2 data-aos="fade-up">
                        <?php echo lang("Translate.titulo"); ?>
                    </h2>
                    <p data-aos="fade-up" data-aos-delay="100">
                        <?php echo lang("Translate.subtitulo") ?>
                    </p>
                    <?php if (session()->getFlashData('reserva')): ?>
                    <div class="row">
                        <div class="alert alert-success" data-aos="fade-right" data-aos-delay="800">
                            <strong><?= session()->getFlashData('reserva') ?></strong>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (session()->get('logged_in')): ?>
                    <?php if (session()->get('permisos_user')["perm7"] == 1): ?>
                    <div class="d-flex div-opReservas" data-aos="fade-up" data-aos-delay="200"
                        data-haysesion="<?= session()->get('logged_in') ?>">
                        <a id="reservarMesa" class="btn-book-a-table opReservas">
                            <?php echo lang('Translate.reserva-mesa'); ?>
                        </a>
                        <a id="reservarHabitacion" class="btn-book-a-table opReservas" style="background-color: blue;">
                            <?php echo lang('Translate.reserva-hab'); ?>
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php else: ?>
                    <div class="d-flex justify-content-center" data-aos="fade-up" data-aos-delay="200"
                        data-haysesion="<?= session()->get('logged_in') ?>">
                        <p style="font-style: italic; font-weight: bold; color: red;">
                            <?php echo lang('Translate.debes-iniciar-sesion'); ?>
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-5 order-1 order-lg-2 text-center text-lg-start">
                    <img src="<?php echo base_url('assets/img/HOSTAL - RESTAURANTE.png'); ?>" class="img-fluid" alt=""
                        data-aos="zoom-out" data-aos-delay="300">
                </div>
            </div>
        </div>
    </section><!-- End Hero Section -->

    <main id="main">

        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <h2>
                        <?php echo lang('Translate.acerca-de'); ?>
                    </h2>
                    <p>
                        <?php echo lang('Translate.our-historia'); ?>
                    </p>
                </div>

                <div class="row gy-4">
                    <div class="col-lg-7 position-relative about-img"
                        style="background-image: url(<?php echo base_url('assets/img/placa.jpeg'); ?>) ;"
                        data-aos="fade-up" data-aos-delay="150">
                        <div class="call-us position-absolute">
                            <h4>
                                <?php echo lang('Translate.reserva-mesa-ahora'); ?>
                            </h4>
                            <p>+34 952 71 45 02</p>
                        </div>
                    </div>
                    <div class="col-lg-5 d-flex align-items-end" data-aos="fade-up" data-aos-delay="300">
                        <div class="content ps-0 ps-lg-5">
                            <p class="fst-italic">
                                <?php echo lang('Textos.t1'); ?>
                            </p>
                            <ul>
                                <li><i class="bi bi-check2-all"></i>
                                    <?php echo lang('Textos.t3'); ?></li>
                                <li><i class="bi bi-check2-all"></i>
                                    <?php echo lang('Textos.t4'); ?></li>
                                <li><i class="bi bi-check2-all"></i>
                                    <?php echo lang('Textos.t5'); ?></li>
                            </ul>
                            <p>
                                <?php echo lang('Textos.t2'); ?>
                            </p>

                            <div class="position-relative mt-4">
                                <img src="<?php echo base_url('assets/img/barquita.jpg'); ?>" class="img-fluid" alt="">
                                <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" class="glightbox play-btn"></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section><!-- End About Section -->

        <!-- ======= Why Us Section ======= -->
        <section id="why-us" class="why-us section-bg">
            <div class="container" data-aos="fade-up">

                <div class="row gy-4">

                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="why-box">
                            <h3>
                                <?php echo lang('Translate.why-mejias'); ?>
                            </h3>
                            <p>
                                <?php echo lang('Textos.t6'); ?>
                            </p>
                        </div>
                    </div><!-- End Why Box -->

                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="row gy-4">

                            <div class="col-xl-4" data-aos="fade-up" data-aos-delay="200">
                                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                    <i class="bi bi-egg-fried"></i>
                                    <h4>
                                        <?php echo lang('Translate.comida-alta'); ?>
                                    </h4>
                                    <p><?php echo lang('Textos.t7'); ?></p>
                                </div>
                            </div><!-- End Icon Box -->

                            <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
                                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                    <i class="bi bi-bell"></i>
                                    <h4>
                                        <?php echo lang('Translate.excelente-cliente'); ?>
                                    </h4>
                                    <p><?php echo lang('Textos.t8'); ?></p>
                                </div>
                            </div><!-- End Icon Box -->

                            <div class="col-xl-4" data-aos="fade-up" data-aos-delay="400">
                                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                    <i class="bi bi-cup-hot"></i>
                                    <h4>
                                        <?php echo lang('Translate.ambiente'); ?>
                                    </h4>
                                    <p><?php echo lang('Textos.t9'); ?>
                                    </p>
                                </div>
                            </div><!-- End Icon Box -->

                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Why Us Section -->

        <!-- ======= Stats Counter Section ======= -->
        <section id="stats-counter" class="stats-counter">
            <div class="container" data-aos="zoom-out">

                <div class="row gy-4">

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span style="display: inline-block;" data-purecounter-start="0" data-purecounter-end="962"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>
                                <?php echo lang('Translate.reseñas'); ?>
                            </p>
                        </div>
                    </div><!-- End Stats Item -->
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span style="display: inline-block;"><i class="fa-solid fa-star"></i></span>&nbsp;
                            <span style="display: inline-block;" data-purecounter-start="0" data-purecounter-end="4.3"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>
                                <?php echo lang('Translate.valoracion'); ?>
                            </p>
                        </div>

                    </div>
                    <!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span style="display: inline-block;">
                                <?php echo lang('Translate.mas-de'); ?>
                            </span>&nbsp;
                            <span style="display: inline-block;" data-purecounter-start="0" data-purecounter-end="47"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>
                                <?php echo lang('Translate.años-exp'); ?>
                            </p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span style="display: inline-block;">
                                <?php echo lang('Translate.mas-de'); ?>
                            </span>&nbsp;
                            <span style="display: inline-block;" data-purecounter-start="0" data-purecounter-end="20"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>
                                <?php echo lang('Translate.trabajadores'); ?>
                            </p>
                        </div>
                    </div><!-- End Stats Item -->

                </div>

            </div>
        </section><!-- End Stats Counter Section -->

        <!-- ======= In Memoriam Section ======= -->

        <section id="in-memorian" class="in-memorian">
            <div class="container" data-aos="fade-up">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-6 d-flex flex-column justify-content-center gap-3">
                        <div class="img-antonio d-flex justify-content-center">
                            <img src="<?=base_url('assets/img/antonio.png')?>" alt="Antonio Mejías Rubio">
                        </div>
                        <div class="fecha-antonio d-flex justify-content-center text-center">
                            <span>26/12/1957 - 30/12/2022</span>
                        </div>
                    </div>
                    <div class="col-xl-6 d-flex flex-column gap-1">
                        <div class="section-header">
                            <h2>
                                <?php echo lang('Translate.in-memoriam'); ?>
                            </h2>
                            <p>Antonio Mejías Rubio</span></p>
                        </div>
                        <div class="col-md-12">
                            <p><?php echo lang('Textos.t13'); ?></p>
                            <p><?php echo lang('Textos.t14'); ?></p>
                            <p><?php echo lang('Textos.t15'); ?></p>
                            <span class="firma text-md-right">Antonio.</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= Menu Section ======= -->
        <section id="menu" class="menu">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <h2>
                        <?php echo lang('Translate.our-menu'); ?>
                    </h2>
                    <p>
                        <?php echo lang('Translate.vistazo-carta'); ?>
                    </p>
                </div>

                

                <div class="col-lg-12 text-center my-4">
                    <a href="<?=base_url('carta/1')?>" id="b-verCarta" class="btn btn-book-a-table">
                        <?php echo lang('Translate.ver-carta'); ?>
                    </a>
                </div>

            </div>
        </section><!-- End Menu Section -->

        <!-- ======= Testimonials Section ======= -->
        <section id="testimonials" class="testimonials section-bg">
            <div class="container cont-reviews" data-aos="fade-up">

                <div class="section-header">
                    <h2>
                        <?php echo lang('Translate.reseñas'); ?>
                    </h2>
                    <p>
                        <?php echo lang('Translate.opinando'); ?>
                    </p>
                </div>

                <div class="slides-1 swiper" data-aos="fade-up" data-aos-delay="100">
                    <div class="swiper-wrapper">

                        <?php foreach($reviews as $review): ?>

                        <?php
                        $stars = "";
                        for ($cont = 1; $cont <= $review['rating']; $cont++)
                            $stars .= '<i class="bi bi-star-fill"></i>';
                        ?>
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="row gy-4 justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="testimonial-content">
                                            <p>
                                                <i class="bi bi-quote quote-icon-left"></i>
                                                <?=$review["review_text"]?>
                                                <i class="bi bi-quote quote-icon-right"></i>
                                            </p>
                                            <h3><?=$review["author_name"]?></h3>
                                            <div class="stars">
                                                <?=$stars?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End testimonial item -->
                        <?php endforeach ?>

                    </div>
                    <div class="swiper-pagination"></div>
                </div>
        </section><!-- End Testimonials Section -->

        <!-- ======= Events Section ======= -->
        <section id="events" class="events">
            <div class="container-fluid" data-aos="fade-up">

                <div class="section-header">
                    <h2>
                        <?php echo lang('Translate.eventos'); ?>
                    </h2>
                    <p>
                        <?php echo lang('Translate.comparte-momentos'); ?>
                    </p>
                </div>

                <div class="slides-3 swiper" data-aos="fade-up" data-aos-delay="100">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide event-item d-flex flex-column justify-content-end"
                            style="background-image: url(assets/img/bautizos.jpg)">
                            <h3>
                                <?php echo lang('Translate.bautizos'); ?>
                            </h3>
                            <div class="price align-self-start">99€</div>
                        </div><!-- End Event item -->

                        <div class="swiper-slide event-item d-flex flex-column justify-content-end"
                            style="background-image: url(assets/img/comuniones.png)">
                            <h3>
                                <?php echo lang('Translate.comuniones'); ?>
                            </h3>
                            <div class="price align-self-start">289€</div>
                        </div><!-- End Event item -->

                        <div class="swiper-slide event-item d-flex flex-column justify-content-end"
                            style="background-image: url(assets/img/comidas-empresa.jpg)">
                            <h3>
                                <?php echo lang('Translate.comidas-empresa'); ?>
                            </h3>
                            <div class="price align-self-start">499€</div>
                        </div><!-- End Event item -->

                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>
        </section><!-- End Events Section -->

        <!-- ======= Habitaciones Section ======= -->
        <section id="habitaciones" class="chefs section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <h2>
                        <?php echo lang('Translate.habitaciones'); ?>
                    </h2>
                    <p>
                        <?php echo lang('Translate.descanse'); ?>
                    </p>
                </div>

                <div class="row gy-4">

                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                        <div class="chef-member">
                            <div class="member-img">
                                <img src="assets/img/habitaciones/habitacion-1.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="member-info">
                                <h4>
                                    <?php echo lang('Translate.camas-comodas'); ?>
                                </h4>
                                <p><?php echo lang('Textos.t10'); ?></p>
                            </div>
                        </div>
                    </div><!-- End Chefs Member -->

                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                        <div class="chef-member">
                            <div class="member-img">
                                <img src="assets/img/habitaciones/habitacion-2.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="member-info">
                                <h4>
                                    <?php echo lang('Translate.baños'); ?>
                                </h4>
                                <p><?php echo lang('Textos.t11'); ?></p>
                            </div>
                        </div>
                    </div><!-- End Chefs Member -->

                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
                        <div class="chef-member">
                            <div class="member-img">
                                <img src="assets/img/habitaciones/habitacion-3.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="member-info">
                                <h4>
                                    <?php echo lang('Translate.salas-estar'); ?>
                                </h4>
                                <p><?php echo lang('Textos.t12'); ?></p>
                            </div>
                        </div>
                    </div><!-- End Chefs Member -->

                </div>

                <div class="col-lg-12 text-center my-4">
                    <a id="ver-habitaciones" class="btn btn-book-a-table">
                        <?php echo lang('Translate.ver-hab'); ?>
                    </a>
                </div>

            </div>
        </section><!-- End Chefs Section -->

        <!-- ======= Gallery Section ======= -->
        <section id="gallery" class="gallery">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <h2>
                        <?php echo lang('Translate.galeria'); ?>
                    </h2>
                    <p>
                        <?php echo lang('Translate.some-fotos'); ?>
                    </p>
                </div>

                <div class="gallery-slider swiper">
                    <div class="swiper-wrapper align-items-center">
                        <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                                href="assets/img/gallery/gallery-1.jpg"><img src="assets/img/gallery/gallery-1.jpg"
                                    class="img-fluid" alt=""></a></div>
                        <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                                href="assets/img/gallery/gallery-2.jpg"><img src="assets/img/gallery/gallery-2.jpg"
                                    class="img-fluid" alt=""></a></div>
                        <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                                href="assets/img/gallery/gallery-3.jpg"><img src="assets/img/gallery/gallery-3.jpg"
                                    class="img-fluid" alt=""></a></div>
                        <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                                href="assets/img/gallery/gallery-4.jpg"><img src="assets/img/gallery/gallery-4.jpg"
                                    class="img-fluid" alt=""></a></div>
                        <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                                href="assets/img/gallery/gallery-5.jpg"><img src="assets/img/gallery/gallery-5.jpg"
                                    class="img-fluid" alt=""></a></div>
                        <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                                href="assets/img/gallery/gallery-6.jpg"><img src="assets/img/gallery/gallery-6.jpg"
                                    class="img-fluid" alt=""></a></div>
                        <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                                href="assets/img/gallery/gallery-7.jpg"><img src="assets/img/gallery/gallery-7.jpg"
                                    class="img-fluid" alt=""></a></div>
                        <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                                href="assets/img/gallery/gallery-8.jpg"><img src="assets/img/gallery/gallery-8.jpg"
                                    class="img-fluid" alt=""></a></div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>
        </section><!-- End Gallery Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <h2>
                        <?php echo lang('Translate.contacto'); ?>
                    </h2>
                    <p>
                        <?php echo lang('Translate.need-help'); ?>
                    </p>
                </div>

                <div class="mb-3">
                    <iframe style="border:0; width: 100%; height: 350px;"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3181.225064664895!2d-4.300078349202096!3d37.123560179784505!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd727be62b0bdea1%3A0x2dad48171be46d1f!2sHostal%20Restaurante%20Mejias!5e0!3m2!1ses-419!2ses!4v1680520140059!5m2!1ses-419!2ses"
                        frameborder="0" allowfullscreen></iframe>
                </div><!-- End Google Maps -->

                <div class="div-distancia mt-4 mb-4 text-center">
                    Estás a <span>50 km</span> del restaurante.
                </div>

                <div class="row gy-4">

                    <div class="col-md-6">
                        <div class="info-item  d-flex align-items-center" style="background-color: #fff !important;">
                            <i class="icon bi bi-map flex-shrink-0"></i>
                            <div>
                                <h3>
                                    <?php echo lang('Translate.direccion'); ?>
                                </h3>
                                <p>C. Estación Salinas, 2, 29315 - Estación de Salinas (Málaga)</p>
                            </div>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center" style="background-color: #fff !important;">
                            <i class="icon bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h3>
                                    <?php echo lang('Translate.correo'); ?>
                                </h3>
                                <p>hostalmejias@hotmail.com</p>
                            </div>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="col-md-6">
                        <div class="info-item  d-flex align-items-center" style="background-color: #fff !important;">
                            <i class="icon bi bi-telephone flex-shrink-0"></i>
                            <div>
                                <h3>
                                    <?php echo lang('Translate.call-us'); ?>
                                </h3>
                                <p>+34 952 71 45 02</p>
                            </div>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="col-md-6">
                        <div class="info-item  d-flex align-items-center" style="background-color: #fff !important;">
                            <i class="icon bi bi-clock flex-shrink-0"></i>
                            <div>
                                <h3>
                                    <?php echo lang('Translate.horario'); ?>
                                </h3>
                                <div>
                                    <strong>
                                        <?php echo lang('Translate.every-day'); ?>:
                                    </strong> 07:00 - 00:00
                                </div>
                            </div>
                        </div>
                    </div><!-- End Info Item -->

                </div>
            </div>
        </section><!-- End Contact Section -->

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
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/yummy-bootstrap-restaurant-website-template/ -->
                Designed by David Morales 2ºDAW
            </div>
        </div>

    </footer><!-- End Footer -->
    <!-- End Footer -->

    <!-- Modales -->
    <div class="modal fade" id="modalLogin">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                        <?php echo lang('Translate.bienvenido'); ?>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="opciones-login d-flex flex-column justify-content-between">
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-login w-100 mb-2">
                                    <?php echo lang('Translate.iniciar-sesion'); ?>
                                </button>
                            </div>
                            <div class="col">
                                <button class="btn btn-register w-100 mb-2">
                                    <?php echo lang('Translate.registrarse'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="login-form">
                        <div class="card shadow-lg">
                            <div class="card-body p-5">
                                <h1 class="fs-4 card-title fw-bold mb-4">
                                    <?php echo lang('Translate.iniciar-sesion'); ?>
                                </h1>
                                <form method="POST" class="needs-validation" novalidate="" autocomplete="off">
                                    <div class="mb-3">
                                        <label class="mb-2 text-muted" for="email-login">
                                            <?php echo lang('Translate.correo'); ?>
                                        </label>
                                        <input id="email-login" type="email" class="form-control" name="email-login"
                                            value="" required autofocus>
                                        <div class="invalid-feedback">
                                            <?php echo lang('Translate.correo-inv'); ?>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="mb-2 w-100">
                                            <label class="text-muted" for="password-login">
                                                <?php echo lang('Translate.contraseña'); ?>
                                            </label>
                                        </div>
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="password-login"
                                                id="password-login" aria-label="password"
                                                aria-describedby="show-password-btn">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    id="show-password-btn-login" class="show-password-btn"
                                                    style="border-top-left-radius: none; border-bottom-left-radius: none;">
                                                    <span class="bi bi-eye"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">
                                            <?php echo lang('Translate.contraseña-ob'); ?>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <button type="submit" class="btn login ms-auto">
                                            <?php echo lang('Translate.enviar'); ?>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer py-3 border-0">
                                <div class="text-center">
                                    <?php echo lang('Translate.not-miembro'); ?> <a class="btn-register">
                                        <?php echo lang('Translate.unete'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="register-form" style="display: none;">
                        <div class="card shadow-lg">
                            <div class="card-body p-5">
                                <h1 class="fs-4 card-title fw-bold mb-4">
                                    <?php echo lang('Translate.registrarse'); ?>
                                </h1>
                                <form method="POST" class="needs-validation" novalidate="" autocomplete="off">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="mb-2 text-muted" for="email-register">
                                                    <?php echo lang('Translate.correo'); ?>
                                                </label>
                                                <input id="email-register" type="email" class="form-control"
                                                    name="email-register" value="" required>
                                                <div class="invalid-feedback">
                                                    <?php echo lang('Translate.correo-ob'); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="mb-2 text-muted" for="password-register">
                                                    <?php echo lang('Translate.contraseña'); ?>
                                                </label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" name="password-register"
                                                        id="password-register" aria-label="password"
                                                        aria-describedby="show-password-btn">
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            id="show-password-btn-register" class="show-password-btn"
                                                            style="border-top-left-radius: none; border-bottom-left-radius: none;">
                                                            <i class="bi bi-eye-slash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">
                                                    <?php echo lang('Translate.contraseña-ob'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="mb-2 text-muted" for="name">
                                                    <?php echo lang('Translate.nombre'); ?>
                                                </label>
                                                <input id="nombre" type="text" class="form-control" name="nombre"
                                                    value="" required autofocus>
                                                <div class="invalid-feedback">
                                                    <?php echo lang('Translate.nombre-ob'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="mb-2 text-muted" for="name">
                                                    <?php echo lang('Translate.apellido'); ?>
                                                </label>
                                                <input id="apellido" type="text" class="form-control" name="apellido"
                                                    value="" required autofocus>
                                                <div class="invalid-feedback">
                                                    <?php echo lang('Translate.apellido-ob'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="mb-2 text-muted" for="phone">
                                                    <?php echo lang('Translate.telefono'); ?>
                                                </label>
                                                <input id="phone" type="tel" class="form-control" name="phone">
                                            </div>
                                        </div>
                                    </div>

                                    <p class="form-text text-muted mb-3 text-center">

                                    </p>

                                    <div class="align-items-center d-flex">
                                        <button type="submit" class="btn register ms-auto">
                                            <?php echo lang('Translate.registrarse'); ?>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer py-3 border-0">
                                <div class="text-center">
                                    <?php echo lang('Translate.cuenta-ya'); ?> <a class="btn-login">
                                        <?php echo lang('Translate.inicia-sesion-ya'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/aos/aos.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/glightbox/js/glightbox.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/purecounter/purecounter_vanilla.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/swiper/swiper-bundle.min.js'); ?>"></script>

    <!-- Template Main JS File -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="<?php echo base_url('assets/js/formsLogin.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/main.js'); ?>"></script>
    <script src="<?=base_url('assets/js/inicio.js')?>"></script>

</body>

</html>