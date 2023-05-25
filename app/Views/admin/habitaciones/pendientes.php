<h1 class="mt-4"><i>Reservas de habitación Realizadas</i></h1>

<section class="pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h3>Elije una:</h3>
            </div>
            <div class="col-6 d-flex justify-content-end column-gap-2">
                <a href="#carruselHabitaciones" class="btn btn-primary" role="button" data-slide="prev">
                    <i class="fa fa-arrow-left"></i>
                </a>
                <a href="#carruselHabitaciones" class="btn btn-primary" role="button" data-slide="next">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
        <div class="col-12">
            <div id="carruselHabitaciones" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $count = 0;
                    foreach ($reservas as $clave => $reserva):
                        if ($count % 3 == 0):
                            $active = ($count == 0) ? 'active' : '';
                            echo '<div class="carousel-item ' . $active . '">';
                            echo '<div class="row">';
                        endif;
                        ?>
                        <div class="col-sm-4 mb-3">
                            <div class="card">
                                <img class="img-fluid" alt="100%x280" src="https://images.unsplash.com/photo-1517760444937-f6397edcbbcd?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1080&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjMyMDc0fQ&amp;s=42b2d9ae6feb9c4ff98b9133addfb698">
                                <div class="card-body">
                                    <h4 class="card-title text-center">
                                        <i class="fa-solid fa-calendar-days"></i>
                                        Datos Reserva
                                    </h4>
                                    <div class="container datos-reservas-hab mt-2">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <i class="fa-solid fa-user"></i>
                                                Nombre Apellido
                                            </div>
                                            <div class="col-md-6">
                                                <i class="fa-solid fa-person-walking-luggage"></i>
                                                Fecha de inicio
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <i class="fa-solid fa-phone-volume"></i>
                                                Nº teléfono
                                            </div>
                                            <div class="col-md-6">
                                                <i class="fa-solid fa-person-walking-luggage fa-flip-horizontal"></i>
                                                Fecha de fin
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <i class="fa-solid fa-people-roof"></i>
                                                Nº huéspedes
                                            </div>
                                            <div class="col-md-6">
                                                <i class="fa-solid fa-building"></i>
                                                Nº habitacion
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container div-botones mt-2">
                                        <div class="row d-flex justify-content-center column-gap-2">
                                            <button type="button" class="btn btn-success col-sm-5">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger col-sm-5">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($count % 3 == 2 || $clave == count($reservas) - 1):
                            echo '</div>';
                            echo '</div>';
                        endif;
                        $count++;
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>



<script src="<?=base_url('assets/js/reservas-hab-p.js')?>"></script>