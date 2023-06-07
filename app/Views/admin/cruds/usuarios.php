<h1 class="mt-4">CRUD Usuarios</h1>

<div class="container mt-4">
    <div class="row">
        <div class="col-xl-12">
            <div class="card filtros-usuarios">
                <div class="card-header">
                    <i class="fa-solid fa-filter"></i>
                    Filtros
                </div>
                <div class="card-body">
                    <div class="container">
                        <form class="col-xl-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="nombre" class="form-label">Nombre:</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="apellido" class="form-label">1º Apellido:</label>
                                    <input type="text" name="apellido" id="apellido" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="puntos" class="form-label">Puntos:</label>
                                    <input type="number" name="puntos" id="puntos" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="borrado" class="form-label">¿Se encuentra borrado?:</label>
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="borrado" id="radio-no" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="btnradio1">No</label>

                                        <input type="radio" class="btn-check" name="borrado" id="radio-si" autocomplete="off" checked>
                                        <label class="btn btn-outline-primary" for="btnradio2">Sí</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label for="roles" class="form-label">Rol:</label>
                                    <select name="roles" id="roles" class="form-control">
                                        <option selected disabled>Seleccionar...</option>
                                        <?php foreach ($roles as $rol): ?>
                                        <option value="<?=$rol["id_rol"]?>"><?=$rol["nombre"]?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="email" class="form-label">Correo electrónico:</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="password" class="form-label">Contraseña:</label>
                                    <input type="text" name="password" id="password" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="telefono" class="form-label">Nº Teléfono:</label>
                                    <input type="tel" name="telefono" id="telefono" class="form-control">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="container d-flex justify-content-center">
                                    <button class="btn btn-warning" id="b-filtrar">
                                        Filtrar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 mb-4">
        <div class="col-xl-12">
            <div class="card card-tabla-crud-rm">
                <div class="card-header">
                    <i class="fa-solid fa-table"></i>
                    Tabla
                </div>
                <div class="card-body">
                    <table id="tabla-usuarios" class="tabla-crud table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID Reserva Mesa</th>
                                <th>Mesa Asignada</th>
                                <th>Estado</th>
                                <th>Email Usuario</th>
                                <th>Nº Teléfono</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Nº Comensales</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID Reserva Mesa</th>
                                <th>Mesa Asignada</th>
                                <th>Estado</th>
                                <th>Email Usuario</th>
                                <th>Nº Teléfono</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Nº Comensales</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>