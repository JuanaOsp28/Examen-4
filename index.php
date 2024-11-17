<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/estilos.css">
    <title>CRUD Productos con PHP, PDO, Ajax y Datatables.js</title>
</head>

<body>
<div class="container fondo">
    <h1 class="text-center">CRUD Productos con PHP, PDO, Ajax y Datatables.js</h1>
    <h1 class="text-center">Juana Ospina</h1>

    <div class="row">
        <div class="col-2 offset-10">
            <div class="text-center d-flex justify-content-end">
                <button type="button" class="btn btn-primary w-30" data-bs-toggle="modal" data-bs-target="#modalProducto" id="botonCrear">
                    <i class="bi bi-plus-circle-fill"> Crear Producto</i>
                </button>
            </div>
        </div>
    </div>

    <br><br>
    <div class="table-responsive">
        <table id="datos_producto" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Editar</th>
                <th>Borrar</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal fade" id="modalProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crear Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" id="formulario" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-body">
                        <label for="nombre">Ingrese el nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                        <br>

                        <label for="descripcion">Ingrese la descripción</label>
                        <input type="text" name="descripcion" id="descripcion" class="form-control" required>
                        <br>

                        <label for="precio">Ingrese el precio</label>
                        <input type="number" name="precio" id="precio" class="form-control" step="0.01" required>
                        <br>

                        <label for="cantidad">Ingrese la cantidad</label>
                        <input type="number" name="cantidad" id="cantidad" class="form-control" required>
                        <br>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="id_producto" id="id_producto">
                        <input type="hidden" name="operacion" id="operacion">
                        <input type="submit" name="action" id="action" class="btn btn-success" value="Crear">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#botonCrear").click(function () {
            $("#formulario")[0].reset();
            $(".modal-title").text("Crear Producto");
            $("#action").val("Crear");
            $("#operacion").val("Crear");
        });

        var dataTable = $('#datos_producto').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "obtener_registros.php",
                type: "POST"
            },
            "columnDefs": [
                {
                    "targets": [0, 3, 4],
                    "orderable": false,
                },
            ],
        });

        $(document).on('submit', '#formulario', function (event) {
            event.preventDefault();
            var nombre = $('#nombre').val();
            var descripcion = $('#descripcion').val();
            var precio = $('#precio').val();
            var cantidad = $('#cantidad').val();
            if (nombre !== '' && descripcion !== '' && precio !== '' && cantidad !== '') {
                $.ajax({
                    url: "crear.php",
                    method: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        alert(data);
                        $('#formulario')[0].reset();
                        $('#modalProducto').modal('hide');
                        dataTable.ajax.reload();
                    }
                });
            } else {
                alert("Todos los campos son obligatorios.");
            }
        });

        $(document).on('click', '.editar', function () {
            var id_producto = $(this).attr("id");
            $.ajax({
                url: "obtener_registro.php",
                method: "POST",
                data: {id_producto: id_producto},
                dataType: "json",
                success: function (data) {
                    $('#modalProducto').modal('show');
                    $('#nombre').val(data.nombre);
                    $('#descripcion').val(data.descripcion);
                    $('#precio').val(data.precio);
                    $('#cantidad').val(data.cantidad);
                    $('.modal-title').text("Editar Producto");
                    $('#id_producto').val(id_producto);
                    $('#action').val("Editar");
                    $('#operacion').val("Editar");
                }
            });
        });

        $(document).on('click', '.borrar', function () {
            var id_producto = $(this).attr("id");
            if (confirm("¿Está seguro de borrar este producto: " + id_producto + "?")) {
                $.ajax({
                    url: "borrar.php",
                    method: "POST",
                    data: {id_producto: id_producto},
                    success: function (data) {
                        alert(data);
                        dataTable.ajax.reload();
                    }
                });
            }
        });
    });
</script>
</body>
</html>
