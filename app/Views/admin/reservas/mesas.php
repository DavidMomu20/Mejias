<h1 class="mt-4">Reservas de Mesa Realizadas</h1>

<div class="container">
    <div class="marcoReserva">
        <div class="reservas">
            <?php
        foreach ($reservas as $reserva):
            ?>
            <div class="reserva" data-index="<?=$reserva["id_reserva_mesa"]?>" data-email="<?=$reserva["email"]?>">
                <div class="reserva-contenedor">
                    <div class="div-punzon">
                        <div class="punzon"></div>
                    </div>
                    <div class="div-datos-reserva">
                        <div class="div-dato reserva-nombre">
                            <i class="fas fa-user icono"></i>
                            <span>
                                <?=$reserva["nombre"] . " " . $reserva["apellido"]?>
                            </span>
                        </div>
                        <div class="div-dato reserva-telefono">
                            <i class="fa-solid fa-phone icono"></i>
                            <span>
                                <?=$reserva["telefono"]?>
                            </span>
                        </div>
                        <div class="div-dato reserva-fecha">
                            <i class="far fa-calendar-alt icono"></i>
                            <span>
                                <?=$reserva["fecha"]?>
                            </span>
                        </div>
                        <div class="div-dato reserva-hora">
                            <i class="far fa-clock icono"></i>
                            <span>
                                <?=$reserva["hora"]?>
                            </span>
                        </div>
                        <div class="div-dato reserva-ncomensales">
                            <i class="fas fa-users icono"></i>
                            <span>
                                <?=$reserva["n_comensales"]?>
                            </span>
                        </div>
                    </div>
                    <?php if ($reserva["id_estado"] == 3): ?>
                    <div class="div-botones-reserva">
                        <button type="button" class="btn btn-success b-confirmar-reserva"><i
                                class="fa-solid fa-check"></i></button>
                        <button type="button" class="btn btn-danger b-rechazar-reserva"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php
            endforeach;
        ?>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4 mb-2">
        <?= $pager->links() ?>
    </div>
</div>

<script src="<?=base_url('assets/js/reservas-mesa-p.js')?>"></script>