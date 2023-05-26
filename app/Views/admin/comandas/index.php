<h1 class="mt-4">Comandas</h1>

<div class="container mt-4">
    <div class="accordion" id="carta-accordion">
        <div class="accordion-item bocadillos">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <i class="fa-solid fa-burger"></i> 
                    Bocadillos
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#carta-accordion">
                <div class="accordion-body">
                    <div class="container text-center">
                        <div class="row row-cols-dynamic row-cols-5 g-3">
                            <?php foreach($platos["bocadillos"] as $bocadillo): ?>
                            <div class="col">
                                <div class="card">
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
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <i class="fa-solid fa-utensils"></i> 
                    Platos Combinados
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#carta-accordion">
                <div class="accordion-body">
                    <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                </div>
            </div>
        </div>
        <div class="accordion-item raciones-frias">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <i class="fa-solid fa-snowflake"></i> 
                    Raciones Frías
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#carta-accordion">
                <div class="accordion-body">
                    <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                </div>
            </div>
        </div>
        <div class="accordion-item bebidas">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    <i class="fa-solid fa-whiskey-glass"></i> 
                    Bebidas
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#carta-accordion">
                <div class="accordion-body">
                    <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
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

<!--

-> 1150 px = row-cols-4
-> 

-->