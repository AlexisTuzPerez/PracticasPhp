<?php
    include("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .btn {
            transition: all 0.3s ease;
            border-radius: 8px;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .modal-content {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .modal-header {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            border-radius: 15px 15px 0 0;
        }
        .modal-footer {
            border-radius: 0 0 15px 15px;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #e0e0e0;
        }
        .form-control:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .table th {
            background: #f8f9fa;
            border-bottom: 2px solid #e0e0e0;
        }
        .table td {
            vertical-align: middle;
        }
        .fa-floppy-disk, .fa-ban {
            margin-right: 5px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col12">
                <h1>Catálogo de Alumnos</h1>
            </div>
        </div>
        <div class="row">
            <form id="frmBuscar" name="frmBuscar">
              <div class="mb-3">
                <label class="form-label" for="nombre">Nombres: </label>
                <input class="form-control" type="text" id="nombre_buscar" name="nombre_buscar">
              </div>
              <div class="mb-3">
                <button type="button" name="btnBuscar" id="btnBuscar" class="btn btn-success btn-sm"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
                <button type="button" name="btnNuevo" id="btnNuevo" class="btn btn-warning btn-sm"><i class="fa-solid fa-plus"></i> Nuevo</button>
              </div>  
            </form>
        </div>
        <div class="row">
            <div class="col12" id="tablita" name="tablita">
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" id="form-add-alumno">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white">Nuevo Alumno</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="myForm">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="nombre" class="control-label">Nombre:</label>
                                <input type="text" name="nombre" id="nombre" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="apellido_paterno" class="control-label">Apellido Paterno:</label>
                                <input type="text" name="apellido_paterno" id="nombapellido_paternore" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="apellido_materno" class="control-label">Apellido Materno:</label>
                                <input type="text" name="apellido_materno" id="apellido_materno" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onClick="crearAlumno()"><i class="fa-solid fa-floppy-disk"></i> Crear</button>    
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-ban"></i> Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            $("#btnBuscar").on("click", function(event){
                buscar()
            })

            $("#btnNuevo").on("click", function(event){
                $("#form-add-alumno").modal("show");
            })
        });
        function buscar(){
            $.ajax({
               type:"POST",
               url: "operaciones.php",
               data: "accion=buscar&"+$("#frmBuscar").serialize(),
               cache: false,
               beforeSend: function(){},
               success: function(resultado){
                    $("#tablita").html(resultado);
               },
               error: function(xhr, ajaxOptions, thrownError) {alert (xhr.status); alert(thrownError);}
            });
        }
        function crearAlumno() {
            if($("#nombre").val()=="") {alert("Debes especificar el Nombre");return false;}
            if($("#apellido_paterno").val()=="") {alert("Debes especificar el Apellido Paterno");return false;}
            if($("#apellido_materno").val()=="") {alert("Debes especificar el Apellido Materno");return false;}
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "operaciones.php",
                data: "accion=insertar&"+$("#myForm").serialize(),
                cache: false,
                beforeSend: function(){
                    $("#form-add-alumno").modal("hide");
                },
                success: function(resultado){
                    if (resultado.status=="OK") {
                        buscar()
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {alert (xhr.status); alert(thrownError);}
            })
        }
        $("#form-add-alumno").on("hidden.bs.modal", function(e) {
            $("#myForm")[0].reset();
        })

    </script>
</body>
</html>


<!-- run: 
 
php -S localhost:8000 

-->