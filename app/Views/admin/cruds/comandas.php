<h1 class="mt-4">CRUD Comandas</h1>

<div class="container mt-4">
    <div class="row">
        <div class="col-xl-12">
            <div class="card filtros-comandas">
                <div class="card-header">
                    <i class="fa-solid fa-filter"></i>
                    Filtros
                </div>
                <div class="card-body">
                    <div class="container">
                        <select class="d-none" name="mesas" id="mesas">
                            <option selected disabled>Seleccionar...</option>
                            <?php foreach($mesas as $mesa): ?>
                            <option value="<?=$mesa["id_mesa"]?>"><?=$mesa["id_mesa"]?></option>
                            <?php endforeach; ?>
                        </select>
                        <form action="<?=base_url('admin/crud/comandas')?>" class="col-xl-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="fecha" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha">
                                </div>
                                <div class="col-md-6">
                                    <label for="hora" class="form-label">Hora</label>
                                    <input type="time" name="hora" id="hora" class="form-control">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="precio-total" class="form-label">Precio Total</label>
                                    <input type="number" name="precio-total" id="precio-total" min="1" step="any" class="form-control">
                                </div>
                                <div class="col-md-6">
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
            <div class="card card-tabla-crud-comandas">
                <div class="card-header">
                    <i class="fa-solid fa-table"></i>
                    Tabla
                </div>
                <div class="card-body">
                    <table id="tabla-comandas" class="tabla-crud table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Mesa Asignada</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Precio Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($comandas as $comanda): ?>
                            <tr data-index="<?=$comanda["id_comanda"]?>">
                                <td data-value="<?=$comanda["id_mesa"]?>"><?=$comanda["id_mesa"]?></td>
                                <td><?=$comanda["fecha"]?></td>
                                <td><?=$comanda["hora"]?></td>
                                <td><?=$comanda["precio_total"]?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Mesa Asignada</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Precio Total</th>
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
    var table = $("#tabla-comandas").DataTable({
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

<script src="<?=base_url("assets/js/cruds/comandas.js")?>"></script>