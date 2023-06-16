<section id="carta" class="carta">
    <div class="container">

    <div class="section-header" data-aos="fade-down">
        <h2>
            <?php echo lang('Translate.our-carta'); ?>
        </h2>
        <p>
            <?php echo lang('Translate.pulse-plato'); ?>
        </p>
    </div>

    <div class="row mt-3">

        <div class="col-xl-4" data-aos="fade-right" data-aos-delay="300">
            <aside class="container opciones-carta p-4">
                <div class="row text-center">
                    <span class="my-titles">CATEGORÍAS</span>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <a href="<?=base_url('carta/1')?>" class="categoria">
                            <i class="fa-solid fa-burger"></i>&nbsp;
                            Bocadillos
                        </a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <a href="<?=base_url('carta/2')?>" class="categoria">
                            <i class="fa-solid fa-utensils"></i>&nbsp;
                            Platos Combinados
                        </a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <a href="<?=base_url('carta/3')?>" class="categoria">
                            <i class="fa-solid fa-snowflake"></i>&nbsp;
                            Raciones Frías
                        </a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <a href="<?=base_url('carta/4')?>" class="categoria">
                            <i class="fa-solid fa-fish-fins"></i>&nbsp;
                            Pescados
                        </a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <a href="<?=base_url('carta/5')?>" class="categoria">
                            <i class="fa-solid fa-drumstick-bite"></i>&nbsp;
                            Carnes
                        </a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <a href="<?=base_url('carta/6')?>" class="categoria">
                            <i class="fa-solid fa-ice-cream"></i>&nbsp;
                            Postres
                        </a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <a href="<?=base_url('carta/7')?>" class="categoria">
                            <i class="fa-solid fa-wine-bottle"></i>&nbsp;
                            Vinos
                        </a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <a href="<?=base_url('carta/8')?>" class="categoria">
                            <i class="fa-solid fa-whiskey-glass"></i>&nbsp;
                            Bebidas
                        </a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <a href="<?=base_url('carta/9')?>" class="categoria">
                            <i class="fa-solid fa-shrimp"></i>&nbsp;
                            Tapas
                        </a>
                    </div>
                </div>
            </aside>
        </div>

        <div class="col-xl-8">
            <section class="container text-center">

                <div class="row row-cols-3">
                    <?php foreach ($platos as $plato): ?>
                    <div class="col-lg-4 menu-item" data-precio-entera="<?=$plato["precio_entera"]?>"
                        <?php if (isset($plato["precio_media"])): ?>
                        data-precio-media="<?=$plato["precio_media"]?>"
                        <?php endif; ?>
                        data-alergenos="<?=implode("|", array_column($plato["alergenos"], "foto"))?>">
                        <img src="<?=base_url('assets/img/platos/' . $plato["imagen"])?>" class="menu-img img-fluid" alt="">
                        <h4><?=$plato["nombre"]?></h4>
                        <p class="price">
                            <?=$plato["precio_entera"]?>€
                        </p>
                    </div><!-- Menu Item -->
                    <?php endforeach; ?>
                </div>
                
            </section>
        </div>

    </div>

    </div>
</section>

<script src="<?=base_url('assets/js/carta.js')?>"></script>