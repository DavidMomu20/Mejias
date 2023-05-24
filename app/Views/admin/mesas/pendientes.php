<h1 class="mt-4"><i>Reservas de Mesa Realizadas</i></h1>

<div class="container">
  <div class="marcoReserva">
    <?php
    if ($contador > 8):
        ?>
        <div class="prev">
            <button><</button>
        </div>
        <?php
    endif;
    ?>
    <div class="reservas">
        <?php
        for ($cont = 0; $cont < $contador; $cont++):
            ?>
            <div class="reserva" data-index="<?=$reservas[$cont]->id_reserva_mesa?>">
                <div class="reserva-contenedor">
                    <div class="div-punzon">
                        <div class="punzon"></div>
                    </div>
                    <div class="div-datos-reserva">
                        <div class="div-dato reserva-nombre">
                            <i class="fas fa-user icono"></i>
                            <span><?=$reservas[$cont]->nombre . " " . $reservas[$cont]->apellido?></span>
                        </div>
                        <div class="div-dato reserva-telefono">
                            <i class="fa-solid fa-phone icono"></i>
                            <span><?=$reservas[$cont]->telefono?></span>
                        </div>
                        <div class="div-dato reserva-fecha">
                            <i class="far fa-calendar-alt icono"></i>
                            <span><?=$reservas[$cont]->fecha?></span>
                        </div>
                        <div class="div-dato reserva-hora">
                            <i class="far fa-clock icono"></i>
                            <span><?=$reservas[$cont]->hora?></span>
                        </div>
                        <div class="div-dato reserva-ncomensales">
                            <i class="fas fa-users icono"></i>
                            <span><?=$reservas[$cont]->n_comensales?></span>
                        </div>
                    </div>
                    <div class="div-botones-reserva">
                        <button type="button" class="btn btn-success b-confirmar-reserva"><i class="fa-solid fa-check"></i></button>
                        <button type="button" class="btn btn-danger b-rechazar-reserva"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
            <?php
            endfor;
        ?>
    </div>
    <?php
    if ($contador > 8):
        ?>
        <div class="next">
            <button>></button>
        </div>
        <?php
    endif;
    ?>
  </div>
</div>

<script src="<?=base_url('assets/js/reservas-mesa-p.js')?>"></script>