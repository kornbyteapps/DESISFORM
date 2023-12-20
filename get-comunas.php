<?php
// Aquí deberías incluir la conexión a tu base de datos
$databaseConfig = array(
    'host' => 'localhost:4306',
    'usuario' => 'root',
    'contrasena' => '',
    'db' => 'votacion_db'
);
$conexion = new mysqli($GLOBALS['databaseConfig']['host'], $GLOBALS['databaseConfig']['usuario'], $GLOBALS['databaseConfig']['contrasena'], $GLOBALS['databaseConfig']['db']);

if (isset($_GET['region'])) {
    $regionSeleccionada = $_GET['region'];

    // Consultar las comunas de la región seleccionada desde la base de datos
    $query = "SELECT id_comuna, nombre_comuna FROM comunas WHERE id_provincia IN 
              (SELECT id_provincia FROM provincias WHERE id_region = $regionSeleccionada)";
    $result = mysqli_query($conexion, $query);

    $comunas = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $comunas[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($comunas);
}
