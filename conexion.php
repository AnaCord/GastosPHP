<?php
try {
    $conexion = new PDO(
        "mysql:dbname=u768712027_bdd_gastos; host=congresoicc.com",
        "u768712027_userGastos",
        "GastosProgramacionNegocios123456789."
    );


    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>