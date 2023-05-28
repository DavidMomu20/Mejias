<h1 class="mt-4">CRUD Reservas Mesa</h1>

<div class="container mt-4">
    <div class="row">
        <div class="col-xl-12">
            <div class="card filtros-reservas-mesa">
                <div class="card-header">
                    <i class="fa-solid fa-filter"></i>
                    Filtros
                </div>
                <div class="card-body">
                    <div class="container">
                        <form class="col-xl-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="mesas" class="form-label">Mesa</label>
                                    <select id="mesas" class="form-select">
                                        <option selected disabled>Seleccionar...</option>
                                        <?php
                                        foreach($mesas as $mesa):
                                            ?>
                                            <option value="<?=$mesa["id_mesa"]?>"><?=$mesa["id_mesa"]?></option>
                                            <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="fecha" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" id="fecha">
                                </div>
                                <div class="col-md-3">
                                    <label for="hora" class="form-label">Hora</label>
                                    <input type="time" class="form-control" id="hora">
                                </div>
                                <div class="col-md-4">
                                    <label for="usuarios" class="form-label">Correo electrónico</label>
                                    <select name="usuarios" id="usuarios" for="usuarios" class="form-select select-2" style="padding-bottom: 2%">
                                        <option selected disabled>Seleccionar...</option>
                                        <?php foreach($usuarios as $usuario): ?>
                                        <option value="<?=$usuario["id_usuario"]?>"><?=$usuario["email"]?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-2">
                                    <label for="estados" class="form-label">Estado</label>
                                    <select name="estados" id="estados" class="form-select">
                                        <option selected disabled>Seleccionar...</option>
                                        <?php
                                        foreach($estados as $estado):
                                            ?>
                                            <option value="<?=$estado["id_estado"]?>"><?=$estado["descripcion"]?></option>
                                            <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="n_comensales" class="form-label">Nº Comensales</label>
                                    <input type="number" name="n_comensales" id="n_comensales" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="phone" name="telefono" id="telefono" class="form-control">
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
                    <table id="tabla-reservas-mesa" class="tabla-crud table table-striped">
                    <thead>
                        <tr>
                            <th>ID Reserva Mesa</th>
                            <th>Mesa Asignada</th>
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
                            <th>Email Usuario</th>
                            <th>Nº Teléfono</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Nº Comensales</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach($reservas as $reserva): ?>
                        <tr>
                            <td><?=$reserva["id_reserva_mesa"]?></td>
                            <td><?php echo (is_null($reserva["id_mesa"]) ? "<i>Sin asignar</i>" : $reserva["id_mesa"]); ?></td>
                            <td><?=$reserva["email"]?></td>
                            <td><?=$reserva["telefono"]?></td>
                            <td><?=date("d/m/Y", strtotime($reserva["fecha"]))?></td>
                            <td><?=$reserva["hora"]?></td>
                            <td><?=$reserva["n_comensales"]?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?=base_url("assets/js/cruds/reservas-mesa.js")?>"></script>