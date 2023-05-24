<h1 class="mt-4"><i>Reservas de habitación Realizadas</i></h1>

<div id="carouselExampleControls" class="carousel carousel-habs" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php 
            foreach ($reservas as $reserva):
                ?>
                <div class="carousel-item">
                    <div class="card" date-index="<?=$reserva->id_reserva_hab?>">
                        <div class="img-wrapper"><img src="<?=base_url('assets/img/habitaciones/' . $reserva->foto)?>" class="d-block w-100" alt="Habitación <?=$reserva->num_habitacion?>"> </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="far fa-calendar-alt icono"></i>
                                Datos Reserva
                            </h5>
                            <div class="div-datos-reserva">
                                <div class="div-dato reserva-nombre">
                                    <i class="fas fa-user icono"></i>
                                    <span><?=$reserva->nombre . " " . $reserva->apellido?></span>
                                </div>
                                <div class="div-dato reserva-fecha-inicio">
                                    <i class="fa-solid fa-person-running"></i>
                                    <span><?=$reserva->fecha_inicio?></span>
                                </div>
                                <div class="div-dato reserva-telefono">
                                    <i class="fa-solid fa-phone icono"></i>
                                    <span><?=$reserva->telefono?></span>
                                </div>
                                <div class="div-dato reserva-fecha-fin">
                                    <i class="fa-solid fa-person-running fa-flip-horizontal"></i>
                                    <span><?=$reserva->fecha_fin?></span>
                                </div>
                                <div class="div-dato reserva-nhuespedes">
                                    <i class="fa-solid fa-people-roof"></i>
                                    <span><?=$reserva->n_huespedes?></span>
                                </div>
                                <div class="div-dato reserva-habitacion">
                                    <i class="fa-solid fa-building"></i>
                                    <span>Habitación <?=$reserva->num_habitacion?></span>
                                </div>
                            </div>
                            <div class="div-botones-reserva">
                                <button type="button" class="btn btn-success b-confirmar-reserva"><i class="fa-solid fa-check"></i></button>
                                <button type="button" class="btn btn-danger b-rechazar-reserva"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
            ?>
        </div>
        <?php
        if ($contador > 3):
            ?>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            <?php
        endif;
        ?>
    </div>

<script src="<?=base_url('assets/js/reservas-hab-p.js')?>"></script>