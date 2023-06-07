<div class="container">
    <div class="row d-flex justify-content-center gap-4">
        <div class="col-xl-4 d-flex justify-content-center align-items-center">
            <div class="container text-center">
                <?php if (session()->get('logged_in')): ?>
                <?php if (session()->get('permisos_user')["perm7"] == 1): ?>
                <div class="row">
                    <span>Usted posee:</span>
                    <div class="col-md-12 d-flex flex-column justify-content-center">
                        <span style="display: inline-block;" data-purecounter-start="0" data-purecounter-end="<?=$usuario["puntos"]?>"
                                        data-purecounter-duration="1" class="purecounter puntos-user"></span>
                        <span>
                            <i class="fa-solid fa-mug-hot fa-bounce"></i> 
                            puntos
                        </span>
                    </div>
                    <span class="recuerda mt-4 text-center">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        Recuerde que los puntos SÓLO sirven para<br> realizar descuentos en las reservas de habitaciones.
                        <br><br>
                        Al realizar una reserva de mesa, ganarás 15 puntos.
                        <br><br>
                        <b>Cada punto = 0.05€</b>
                    </span>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="col-md-12 text-center mb-4">
                <h2>Tus datos</h2>
            </div>
            <form method="post">
                <div class="row">
                    <div class="col-md-12">
                       <label for="email" class="form-label">Correo electrónico:</label> 
                       <input type="email" name="email" id="email" class="form-control" value="<?=$usuario["email"]?>">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="accordion accordion-flush" id="accordion-password">
                        <div class="accordion-item">
                                <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Cambiar Contraseña
                                </button>
                                </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordion-password">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">Nueva Contraseña:</label>
                                            <input type="password" name="password" id="password" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="repeat-password" class="form-label">Repetir Nueva Contraseña:</label>
                                            <input type="password" name="repeat-password" id="repeat-password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12 d-flex justify-content-center">
                                            <a href="#" class="btn btn-warning">Cambiar Contraseña</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?=$usuario["nombre"]?>">
                    </div>
                    <div class="col-md-6">
                        <label for="apellido" class="form-label">1º Apellido:</label>
                        <input type="text" name="apellido" id="apellido" class="form-control" value="<?=$usuario["apellido"]?>">
                    </div>
               </div>
               <div class="row mt-3">
                    <div class="col-md-12">
                        <label for="telefono" class="form-label">Nº Teléfono:</label>
                        <input type="tel" name="telefono" id="telefono" class="form-control" value="<?=$usuario["telefono"]?>">
                    </div>
               </div>
               <div class="row mt-4">
                    <div class="col-md-6 d-flex justify-content-center">
                        <a disabled class="btn btn-primary">Modificar datos</a>
                    </div>
                    <div class="col-md-6 d-flex justify-content-center">
                        <a href="<?=base_url('logout')?>" class="btn btn-danger">Cerrar sesión</a>
                    </div>
               </div>
            </form>
        </div>
    </div>
</div>