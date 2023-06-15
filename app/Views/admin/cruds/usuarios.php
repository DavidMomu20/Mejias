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
                        <form action="<?=base_url('admin/crud/filtrar-usuarios')?>" class="col-xl-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="correo" class="form-label">Correo electrónico:</label>
                                    <input type="email" name="correo" id="correo" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="roles" class="form-label">Rol:</label>
                                    <select name="roles" id="roles" class="form-control">
                                        <option selected disabled>Seleccionar...</option>
                                        <?php foreach ($roles as $rol): ?>
                                        <option value="<?=$rol["id_rol"]?>"><?=$rol["nombre"]?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="telefono" class="form-label">Nº Teléfono:</label>
                                    <input type="tel" class="form-control" name="telefono" id="telefono">
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center mt-3">
                                <div class="col-md-4 d-flex flex-column">
                                    <label for="borrado" class="form-label">¿Se encuentra borrado?:</label>
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" value="no" class="btn-check" name="borrado" id="radio-no" autocomplete="off" checked>
                                        <label class="btn btn-outline-primary" for="radio-no">No</label>

                                        <input type="radio" value="si" class="btn-check" name="borrado" id="radio-si" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="radio-si">Sí</label>
                                    </div>
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
                                    <button name="filtrar" class="btn btn-warning" id="b-filtrar">
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
            <div class="card card-tabla-crud-usuarios">
                <div class="card-header">
                    <i class="fa-solid fa-table"></i>
                    Tabla
                </div>
                <div class="card-body">
                    <table id="tabla-usuarios" class="tabla-crud table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Rol</th>
                                <th>Correo electrónico</th>
                                <th>Nº Teléfono</th>
                                <th>Puntos</th>
                                <th>¿Está Borrado?</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($usuarios as $usuario): ?>
                            <tr data-index="<?=$usuario["id_usuario"]?>">
                                <td><?=$usuario["nombre"]?></td>
                                <td><?=$usuario["apellido"]?></td>
                                <td data-value="<?=$usuario["id_rol"]?>"><?=$usuario["rol"]?></td>
                                <td><?=$usuario["email"]?></td>
                                <td><?=$usuario["telefono"]?></td>
                                <td><?php echo (isset($usuario["puntos"])) ? $usuario["puntos"] : "<i>No tiene</i>" ?></td>
                                <td><?php echo ($usuario["borrado"] == "0") ? "No" : "Sí" ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Rol</th>
                                <th>Correo electrónico</th>
                                <th>Nº Teléfono</th>
                                <th>Puntos</th>
                                <th>¿Está Borrado?</th>
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
    var table = $("#tabla-usuarios").DataTable({
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

<script src="<?=base_url("assets/js/cruds/usuarios.js")?>"></script>