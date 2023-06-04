<h1 class="mt-4">Comandas</h1>

<div class="container mt-4">
    <div class="accordion" id="carta-accordion">
        <div class="accordion-item bocadillos">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false aria-controls="collapseOne">
                    <i class="fa-solid fa-burger"></i>&nbsp; 
                    Bocadillos
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#carta-accordion">
                <div class="accordion-body">
                    <div class="container text-center">
                        <div class="row row-cols-dynamic row-cols-5 g-3">
                            <?php foreach($platos["bocadillos"] as $bocadillo): ?>
                            <div class="col">
                                <div class="card" data-precio="<?=$bocadillo["precio"]?>">
                                    <img src="<?=base_url('assets/img/platos/' . $bocadillo["imagen"])?>" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <p class="card-text"><?=$bocadillo["nombre"]?></p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item platos-combinados">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <i class="fa-solid fa-utensils"></i>&nbsp;
                    Platos Combinados
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#carta-accordion">
                <div class="accordion-body">
                    <div class="row row-cols-dynamic row-cols-5 g-3">
                        <?php foreach($platos["platos_combinados"] as $plato_comb): ?>
                        <div class="col">
                            <div class="card" data-precio="<?=$plato_comb["precio"]?>">
                                <img src="<?=base_url('assets/img/platos/' . $plato_comb["imagen"])?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <p class="card-text"><?=$plato_comb["nombre"]?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item raciones-frias">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <i class="fa-solid fa-snowflake"></i>&nbsp;
                    Raciones Frías
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#carta-accordion">
                <div class="accordion-body">
                <div class="row row-cols-dynamic row-cols-5 g-3">
                        <?php foreach($platos["raciones_frias"] as $racion_fria): ?>
                        <div class="col">
                            <div class="card" data-precio="<?=$racion_fria["precio"]?>">
                                <img src="<?=base_url('assets/img/platos/' . $racion_fria["imagen"])?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <p class="card-text"><?=$racion_fria["nombre"]?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item bebidas">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    <i class="fa-solid fa-whiskey-glass"></i>&nbsp; 
                    Bebidas
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#carta-accordion">
                <div class="accordion-body">
                    <div class="row row-cols-dynamic row-cols-5 g-3">
                        <?php foreach($platos["bebidas"] as $bebida): ?>
                        <div class="col">
                            <div class="card" data-precio="<?=$bebida["precio"]?>">
                                <img src="<?=base_url('assets/img/platos/' . $bebida["imagen"])?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <p class="card-text"><?=$bebida["nombre"]?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container d-flex mt-4 justify-content-center div-btn-comanda">
        <div class="row">
            <div class="col-12">
                <button class="btn btn-success b-crear-comanda">Crear Comanda</button>
            </div>
        </div>
    </div>
</div>

<script src="<?=base_url("assets/js/comandas.js")?>"></script>