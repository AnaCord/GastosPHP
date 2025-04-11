<?php
include 'conexion.php';

$error="";
$hay_post = false;
$nombre = "";
$tipoGasto = "";
$valorGasto = "";
if(isset($_REQUEST['submit1'])){
    $hay_post = true;
    $nombre = isset($_REQUEST['txtNombre']) ? $_REQUEST['txtNombre'] : "";
    $tipoGasto = isset($_REQUEST['radioTipo']) ? $_REQUEST['radioTipo'] : "";

    $valorGasto = isset($_REQUEST['cmbGasto']) ? $_REQUEST['cmbGasto'] : "";


    if(!empty($nombre)){
        $nombre = preg_replace("/[^a-zA-ZáéíóúÁÉÍÓÚ]/u","",$nombre);
    }
    else{
        $error .= "El nombre no puede esta vácio<br>";
    }

    if($tipoGasto == ""){
        $error .= "Seleccione un sexo.<br>";
    }

    if($valorGasto ==""){
        $error .= "Seleccione un país";
    }

}

$stm = $conexion->prepare("select * from gastos");
$stm->execute([]);
$resultados = $stm->fetchAll();


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Gastos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
<h1>Gastos</h1>


<div class="container-sm">
    <!-- formulario -->
    <form method="POST" action="index.php">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nombre</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label class="form-label" for="tipoGasto">Tipo de Gasto</label>
            <select class="form-select" name="radioTipo" id="tipoGasto">
                <option value="">Seleccione que tipo de gasto es</option>
                <option value="Alimentacion" <?php echo ($tipoGasto=='Alimentacion')? 'selected' : '' ?> >Alimentacion</option>
                <option value="Salud" <?php echo ($tipoGasto=='Salud')? 'selected' : '' ?>>Salud</option>
                <option value="Transporte" <?php echo  ($tipoGasto=='Transporte')? 'selected' : '' ?>>Transporte</option>
                <option value="Cine" <?php echo  ($tipoGasto=='Cine')? 'selected' : '' ?>>Cine</option>
            </select><br>
        </div>
        <div class="mb-3">
            <label for="txtValor" class="form-label">Valor del gasto</label>
            <input type="number" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>

<div class="container-sm">

    <table class="table table-striped-columns">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Tipo de Gasto</th>
            <th scope="col">Valor de Gasto</th>
        </tr>
        </thead>
        <tbody>


        </tbody>
    </table>

</div>



</body>

</html>
