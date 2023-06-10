<div class="container d-flex justify-content-between align-items-center mt-4">
    <h1>Comandas</h1>
    <button class="btn btn-primary" id="b-info-pedido">
        <i class="fa-solid fa-circle-info"></i>
    </button>
</div>

<div class="container mt-4 comandas">

    <ul class="nav nav-pills gap-2">
        <li class="nav-item cat-comandas">
            <a disabled class="nav-link active" data-id="1" data-bs-toggle="pill" href="#bocadillos">Bocadillos</a>
        </li>
        <li class="nav-item cat-comandas">
            <a disabled class="nav-link" data-id="2" data-bs-toggle="pill" href="#platos-combinados">Platos Combinados</a>
        </li>
        <li class="nav-item cat-comandas">
            <a disabled class="nav-link" data-id="3" data-bs-toggle="pill" href="#raciones-frias">Raciones Frías</a>
        </li>
        <li class="nav-item cat-comandas">
            <a disabled class="nav-link" data-id="4" data-bs-toggle="pill" href="#pescados">Pescados</a>
        </li>
        <li class="nav-item cat-comandas">
            <a disabled class="nav-link" data-id="5" data-bs-toggle="pill" href="#carnes">Carnes</a>
        </li>
        <li class="nav-item cat-comandas">
            <a disabled class="nav-link" data-id="6" data-bs-toggle="pill" href="#postres">Postres</a>
        </li>
        <li class="nav-item cat-comandas">
            <a disabled class="nav-link" data-id="7" data-bs-toggle="pill" href="#vinos">Vinos</a>
        </li>
        <li class="nav-item cat-comandas">
            <a disabled class="nav-link" data-id="8" data-bs-toggle="pill" href="#bebidas">Bebidas</a>
        </li>
        <li class="nav-item cat-comandas">
            <a disabled class="nav-link" data-id="9" data-bs-toggle="pill" href="#tapas">Tapas</a>
        </li>
    </ul>

    <div class="container mt-4 cont-platos">
        
        <div class="loading"> 
            <div class="spinner"></div>
            <span class="cargando">Cargando platos...</span>
        </div>

    </div>
</div>

<script src="<?=base_url('assets/js/comandas.js')?>"></script>