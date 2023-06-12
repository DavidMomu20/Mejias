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
                    <div class="mt-2 text-center">
                        <button type="button" id="b-crud-crear" class="btn btn-success">
                            Crear
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#tabla-usuarios").DataTable({
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
        searching: false,
        ajax: {
            url: "<?php echo base_url('admin/crud/ajax-usuarios'); ?>",
            type: "POST"
        },
        columns: [
            { data: "nombre" },
            { data: "apellido" },
            { data: "rol" },
            { data: "email" },
            { data: "telefono" },
            { 
                data: "puntos", 
                render: function(data, type, row) {
                    if (data === null)
                        return "<td><i>No tiene</i></td>";
                    else
                        return "<td>" + data + "</td>";
                }
            },
            { 
                data: "borrado", 
                render: function(data, type, row) {
                    return "<td>" + ((data === "0") ? "No" : "Sí") + "</td>";
                }
            }
        ], 
        createdRow: function(row, data, dataIndex) {
            $(row).find("td:eq(2)").attr("data-value", data.id_rol);
        },
        drawCallback: function(settings) {
            let table = settings.oInstance.api();
            table.rows().every(function() {
                let row = this.node();
                let rowData = this.data();
                $(row).attr("data-id", rowData.id_usuario);
            });
        }
    })
</script>

<script src="<?=base_url("assets/js/cruds/usuarios.js")?>"></script>