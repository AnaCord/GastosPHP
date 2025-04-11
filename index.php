<?php
include 'conexion.php';

$error="";
$hay_post = false;
$nombre = "";
$tipoGasto = "";
$valorGasto = "";
$codigoGasto = null;
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
        $error .= "Seleccione un tipo de gasto.<br>";
    }

    if($valorGasto ==""){
        $error .= "Ingrese un gasto";
    }

    if(!$error){
        $stm_insertarRegistro = $conexion->prepare("INSERT INTO gastos(nombre, tipoGasto, valorGasto) VALUES(:nombre, :tipoGasto, :valorGasto)");
        $stm_insertarRegistro->execute([
            ':nombre' => $nombre,
            ':tipoGasto' => $tipoGasto,
            ':valorGasto' => $valorGasto
        ]);
        header("Location: index.php?mensaje=registroGuardado");
        exit();
    }

    if(isset($_REQUEST['submit2'])){
        $codigoUsuario = $_REQUEST['id'];
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
            $error .= "Seleccione un tipo de gasto.<br>";
        }

        if($valorGasto==""){
            $error .= "Ingrese un gasto";
        }

        if(!$error){
            $stm_modificar = $conexion->prepare("update gastos set nombre = :nombre, tipoGasto = :tipoGasto, valorGasto = :valorGasto where codigoGasto = :id");
            $stm_modificar->execute([
                ':nombre'=>$nombre,
                ':tipoGasto'=>$tipoGasto,
                ':valorGasto'=>$valorGasto,
                ':id'=> $codigoGasto
            ]);
            header("Location: index.php?mensaje=registroModificado");
            exit();
        }

    }
}


if(isset($_REQUEST['id']) && isset($_REQUEST['op'])){
    $id = $_REQUEST['id'];
    $op = $_REQUEST['op'];

    if($op == 'm'){
        // $stm_seleccionarRegistro = $conexion->prepare("update cliente set nombreUsuario=:nombre, sexo=:sexo, pais:pais");
        $stm_seleccionarRegistro = $conexion->prepare("select * from gastos where codigoGastos=:id");
        $stm_seleccionarRegistro->execute([':id'=>$id]);
        $resultado = $stm_seleccionarRegistro->fetch();
        $codigoUsuario = $resultado['codigoGastos'];
        $nombre = $resultado['nombre'];
        $sexo = $resultado['tipoGasto'];
        $pais = $resultado['valorGasto'];
    }
    else if($op == 'e'){
        $stm_eliminar = $conexion->prepare("delete from gastos where codigoGasto = :id");
        $stm_eliminar->execute([':id'=>$id]);
        header("Location: index.php?mensaje=registroEliminado");
        exit();
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
    <form method="POST" action="ana.php">
        <div class="mb-3">
            <label for="txtNombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="txtNombre" name="txtNombre">
        </div>
        <div class="mb-3">
            <label class="form-label" for="tipoGasto">Tipo de Gasto</label>
            <select class="form-select" name="radioTipo" id="tipoGasto">
                <option value="">Seleccione que tipo de gasto es</option>
                <option value="Alimentacion" <?php echo ($tipoGasto=='Alimentacion')? 'selected' : '' ?>>Alimentación</option>
                <option value="Salud" <?php echo ($tipoGasto=='Salud')? 'selected' : '' ?>>Salud</option>
                <option value="Transporte" <?php echo ($tipoGasto=='Transporte')? 'selected' : '' ?>>Transporte</option>
                <option value="Cine" <?php echo ($tipoGasto=='Cine')? 'selected' : '' ?>>Cine</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="txtValor" class="form-label">Valor del gasto</label>
            <input type="number" class="form-control" name="cmbGasto" id="txtValor">
        </div>
        <button type="submit" class="btn btn-primary" name="submit1">Enviar</button>
    </form>
</div>


<?php if($error):  ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo "<p>$error</p>"; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>


<?php
if(isset($_REQUEST['mensaje'])){
    $mensaje = $_REQUEST['mensaje'];
    ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <?php
        if($mensaje=='registroGuardado'){
            echo "<p>Registro guardado.</p>";
        }
        elseif($mensaje == 'registroModificado'){
            echo "<p>Registro modificado.</p>";
        }
        elseif($mensaje=='registroEliminado'){
            echo "<p>Registro eliminado.</p>";
        }
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <?php
}
?>




<div class="container-sm">

    <table class="table table-striped-columns">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Tipo de Gasto</th>
            <th scope="col">Valor de Gasto</th>
            <th scope="col">Modificar</th>
            <th scope="col">Eliminar</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach($resultados as $registro): ?>
        <tr>
            <td><?php echo $registro['codigoGasto']; ?></td>
            <td><?php echo $registro['nombre']; ?></td>
            <td><?php echo $registro['tipoGasto']; ?></td>
            <td><?php echo $registro['valorGasto']; ?></td>
            <td><a class="btn btn-primary" href="index.php?id=<?php echo $registro['codigoUsuario'] ?>&op=m">Modificar</a></td>
            <td><a class="btn btn-danger" href="index.php?id=<?php echo $registro['codigoUsuario'] ?>&op=e" onclick="return confirm('Desea eliminar el registro');">Eliminar</a></td>
            <?php endforeach; ?>
        </tr>


        </tbody>
    </table>

</div>



</body>

</html>
