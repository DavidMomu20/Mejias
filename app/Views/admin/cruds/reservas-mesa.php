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
                    <table id="tabla-reservas-mesa" class="tabla-crud table table-striped" style="width:100%">
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

<script>
    $("#tabla-reservas-mesa").DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
        },
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 }
        ],
        responsive: true, 
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo base_url('admin/crud/ajax-rm'); ?>",
            type: "POST"
        },
        columns: [
            { data: "id_reserva_mesa" },
            { 
                data: "id_mesa",
                render: function(data, type, row) {
                    let id = ((data === null) ? "<i>Sin asignar</i>" : data);
                    return "<td>" + data + "</td>";
                } 
            },
            { data: "estado" },
            { data: "email" },
            { data: "telefono" },
            { data: "fecha" },
            { data: "hora" },
            { data: "n_comensales" },
        ]
    })

    $("td.sorting_1.dtr-control::before").on("click", function(event) {

        event.stopPropagation();
    })
</script>

<script src="<?=base_url("assets/js/cruds/reservas-mesa.js")?>"></script>