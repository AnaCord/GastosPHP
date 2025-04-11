<?php
try {
    $conexion = new PDO(
        "mysql:host=127.0.0.1;port=3306;dbname=u768712027_bdd_gastos;charset=utf8",
        "root",
        ""
    );

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>