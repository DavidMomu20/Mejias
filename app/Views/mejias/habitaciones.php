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
                                        <div class="col-6">
                                            <label for="capacidad" class="form-label">Capacidad:</label>
                                            <input class="form-control" type="number" name="capacidad" id="capacidad">
                                        </div>
                                        <div class="col-6">
                                            <label for="precio" class="form-label">Precio:</label>
                                            <input class="form-control" type="number" name="precio" id="precio">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="div-habs-scroll">
                                <?php foreach($habitaciones as $habitacion): ?>
                                <div class="habitacion container" data-value="<?=$habitacion["id_habitacion"]?>">
                                    <div class="row">
                                        <div class="col-xl-12 d-flex justify-content-center gap-2">
                                            <div class="col-md-6 img-hab" style="background: url(<?=base_url('assets/img/habitaciones/' . $habitacion["foto"])?>); background-position: center;"></div>
                                            <div class="col-md-3 d-flex flex-column justify-content-center align-items-center gap-2">
                                                <div class="dato-hab numero-hab">Habitación <span><?=$habitacion["num_habitacion"]?></span></div>
                                                <div class="dato-hab capacidad-hab" data-value="<?=$habitacion["capacidad"]?>">
                                                    <i class="fa-solid fa-user-group"></i>
                                                    <span><?=$habitacion["capacidad"]?></span> personas
                                                </div>
                                                <div class="dato-hab precio-hab" data-value="<?=$habitacion["precio"]?>">
                                                    <i class="fa-solid fa-money-bill-wave"></i>
                                                    <span><?=$habitacion["precio"]?>€</span> / noche
                                                </div>
                                            </div>
                                            <div class="div-bReservarHab col-sm-2 d-flex justify-content-center align-items-center">
                                                <button class="btn btn-book-a-table">Reservar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<script src="<?=base_url('assets/js/calendar.js')?>"></script>
<script src="<?=base_url('assets/js/habitaciones.js')?>"></script>
<script src="<?=base_url('assets/js/makeReservaHab.js')?>"></script>