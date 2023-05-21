<section class="habitaciones">
    <div class="container" data-aos="fade-up">

        <div class="section-header">
            <h2>Habitaciones del local</h2>
            <p>Elija una <span>Habitación</span> para reservarla</p>
        </div>

        <div class="row gy-0">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa-solid fa-bed"></i>
                    Habitaciones disponibles
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="filtros-hab">
                                <div class="container">
                                    <div class="row">
                                        <h4 class="col-sm-12">Filtros</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="capacidad" class="form-label">Capacidad:</label>
                                            <input class="form-control" type="number" name="capacidad" id="capacidad">
                                        </div>
                                        <div class="col-4">
                                            <label for="precio" class="form-label">Precio:</label>
                                            <input class="form-control" type="number" name="precio" id="precio">
                                        </div>
                                        <div class="col-4">
                                            <select name="" id="" class="form-select"></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="div-habs-scroll">
                                    <?php
                                    foreach($habitaciones as $habitacion):
                                        ?>
                                        <div class="habitacion" data-value="<?=$habitacion["id_habitacion"]?>">
                                            <div class="datos-habitacion">
                                                <div class="image" style="background: url(<?=base_url('assets/img/habitaciones/' . $habitacion["foto"])?>)"></div>
                                                <div class="datos">
                                                    <div class="dato-hab numero-hab"><span>Habitación</span> <?=$habitacion["num_habitacion"]?></div>
                                                    <div class="dato-hab capacidad-hab" data-value="<?=$habitacion["capacidad"]?>">
                                                        <i class="fa-solid fa-user-group"></i>
                                                        <span><?=$habitacion["capacidad"]?> personas</span>
                                                    </div>
                                                    <div class="dato-hab precio-hab" data-value="<?=$habitacion["precio"]?>">
                                                        <i class="fa-solid fa-money-bill-wave"></i>
                                                        <span><?=$habitacion["precio"]?>€ / noche</span>
                                                    </div>
                                                </div>
                                                <div class="div-bReservarHab">
                                                    <button class="btn btn-book-a-table">Reservar</button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    endforeach;
                                    ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<script src="<?=base_url('assets/js/habitaciones.js')?>"></script>