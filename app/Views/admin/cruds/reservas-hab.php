<h1 class="mt-4">CRUD Reservas Habitaciones</h1>

<div class="container mt-4">
    <div class="row">
        <div class="col-xl-12">
            <div class="card filtros-reservas-hab">
                <div class="card-header">
                    <i class="fa-solid fa-filter"></i>
                    Filtros
                </div>
                <div class="card-body">
                    <select class="d-none" name="habitaciones" id="habitaciones">
                        <?php foreach($habitaciones as $hab): ?>
                        <option value="<?=$hab["id_habitacion"]?>"><?=$hab["num_habitacion"]?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="container">
                        <form action="<?=base_url('admin/crud/reservas-hab')?>" class="col-xl-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="fecha-inicio" class="form-label">Fecha de inicio</label>
                                    <input type="date" class="form-control" id="fecha-inicio" name="fecha-inicio">
                                </div>
                                <div class="col-md-4">
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
                                <div class="col-md-4">
                                    <label for="n_huespedes" class="form-label">Nº Huéspedes</label>
                                    <input type="number" name="n_huespedes" id="n_huespedes" class="form-control">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="fecha-fin" class="form-label">Fecha de fin</label>
                                    <input type="date" class="form-control" id="fecha-fin" name="fecha-fin">
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
                                <div class="col-md-4">
                                    <label for="n-registros" class="form-label">Nº Registros a Mostrar:</label>
                                    <select name="n-registros" id="n-registros" class="form-control">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
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
            <div class="card card-tabla-crud-rh">
                <div class="card-header">
                    <i class="fa-solid fa-table"></i>
                    Tabla
                </div>
                <div class="card-body">
                    <table id="tabla-reservas-hab" class="tabla-crud table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Habitación</th>
                                <th>Estado</th>
                                <th>Email Usuario</th>
                                <th>Fecha Entrada</th>
                                <th>Fecha Salida</th>
                                <th>Nº Huéspedes</th>
                                <th>Puntos Usados</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($reservas_hab as $reserva_hab): ?>
                            <tr data-index="<?=$reserva_hab["id_reserva_hab"]?>">
                                <td data-value="<?=$reserva_hab["id_habitacion"]?>"><?=$reserva_hab["num_habitacion"]?></td>
                                <td data-value="<?=$reserva_hab["id_estado"]?>"><?=$reserva_hab["estado"]?></td>
                                <td data-value="<?=$reserva_hab["id_usuario"]?>"><?=$reserva_hab["email"]?></td>
                                <td><?=$reserva_hab["fecha_inicio"]?></td>
                                <td><?=$reserva_hab["fecha_fin"]?></td>
                                <td><?=$reserva_hab["n_huespedes"]?></td>
                                <td><?=$reserva_hab["puntos_usados"]?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Habitación</th>
                                <th>Estado</th>
                                <th>Email Usuario</th>
                                <th>Fecha Entrada</th>
                                <th>Fecha Salida</th>
                                <th>Nº Huéspedes</th>
                                <th>Puntos Usados</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <?= $pager->links() ?>
                        <button type="button" class="btn b-crud-crear btn-success">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Crear
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var table = $("#tabla-reservas-hab").DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
        },
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 }
        ],
        responsive: true,
        lengthChange: false,
        paging: false, 
        info: false
    })

    $("td.sorting_1.dtr-control::before").on("click", function(event) {

        event.stopPropagation();
    })
</script>

<script src="<?=base_url("assets/js/cruds/reservas-hab.js")?>"></script>