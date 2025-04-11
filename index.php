<?php
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
            <label class="form-label" for="pais">Tipo de Gasto</label>
            <select class="form-select" name="cmbPais" id="pais">
                <option value="">Seleccione que tipo de gasto es</option>
                <option value="Honduras" <?php echo ($pais=='Honduras')? 'selected' : '' ?> >Alimentacion</option>
                <option value="Guatemala" <?php echo ($pais=='Guatemala')? 'selected' : '' ?>>Transporte</option>
                <option value="Mexico" <?php echo  ($pais=='Mexico')? 'selected' : '' ?>>Salud</option>
            </select><br>
        </div>
        <div class="mb-3">
            <label for="txtValor" class="form-label">Valor del gasto</label>
            <input type="number" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
</body>

</html>
