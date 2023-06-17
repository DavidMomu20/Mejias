<h1 class="mt-4">CRUD Platos</h1>

<div class="container mt-4">
    <div class="row">
        <div class="col-xl-12">
            <div class="card filtros-platos">
                <div class="card-header">
                    <i class="fa-solid fa-filter"></i>
                    Filtros
                </div>
                <div class="card-body">
                    <div class="container">
                        <form action="<?=base_url('admin/crud/platos')?>" class="col-xl-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="categorias" class="form-label">Categoría</label>
                                    <select class="form-control" id="categorias" name="categorias">
                                        <option selected disabled>Seleccionar...</option>
                                        <?php foreach($categorias as $categoria): ?>
                                        <option value="<?=$categoria["id_categoria"]?>"><?=$categoria["descripcion"]?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="precio-entera" class="form-label">Precio Ración Entera</label>
                                    <input type="number" name="precio-entera" id="precio-entera" class="form-control">
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
            <div class="card card-tabla-crud-platos">
                <div class="card-header">
                    <i class="fa-solid fa-table"></i>
                    Tabla
                </div>
                <div class="card-body">
                    <table id="tabla-platos" class="tabla-crud table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Precio Ración Entera (€)</th>
                                <th>Precio Media Ración (€)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($platos as $plato): ?>
                            <tr data-index="<?=$plato["id_plato"]?>">
                                <td><img src="<?=base_url('assets/img/platos/' . $plato["imagen"])?>"></td>
                                <td><?=$plato["nombre"]?></td>
                                <td data-value="<?=$plato["id_categoria"]?>"><?=$plato["categoria"]?></td>
                                <td><?=$plato["precio_entera"]?></td>
                                <td><?=$plato["precio_media"]?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Precio Ración Entera (€)</th>
                                <th>Precio Media Ración (€)</th>
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
    var table = $("#tabla-platos").DataTable({
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

<script src="<?=base_url("assets/js/cruds/platos.js")?>"></script>