<?php
// Configuración de la base de datos
$databaseConfig = array(
    'host' => 'localhost:4306',
    'usuario' => 'root',
    'contrasena' => '',
    'db' => 'votacion_db'
);

function getCandidatos()
{
    // Intentar establecer la conexión
    $conexion = new mysqli($GLOBALS['databaseConfig']['host'], $GLOBALS['databaseConfig']['usuario'], $GLOBALS['databaseConfig']['contrasena'], $GLOBALS['databaseConfig']['db']);
    // Verificar errores de conexión
    if ($conexion->connect_error) {
        error_log("Conexión fallida: " . $conexion->connect_error);
        http_response_code(500);
        die("Error en la conexión. Por favor, inténtalo de nuevo más tarde.");
    }
    // Consultar las regiones desde la base de datos utilizando
    $query = "SELECT id_candidato, nombre_candidato FROM candidatos";
    $stmt = $conexion->prepare($query);
    // Verificar errores en la consulta
    if (!$stmt) {
        error_log("Error en la preparación de la consulta: " . $conexion->error);
        http_response_code(500);
        die("Error en la preparación de la consulta. Por favor, inténtalo de nuevo más tarde.");
    }
    // Ejecutar la consulta
    if (!$stmt->execute()) {
        error_log("Error en la ejecución de la consulta: " . $stmt->error);
        http_response_code(500);
        die("Error en la consulta. Por favor, inténtalo de nuevo más tarde.");
    }
    // Obtener resultados
    $result = $stmt->get_result();
    $candidatos = $result->fetch_all(MYSQLI_ASSOC);
    // Cerrar la consulta y la conexión
    $stmt->close();
    $conexion->close();
    // Devolver el resultado como JSON
    return $candidatos;
}
// Llamar a la función y enviar la respuesta JSON
header('Content-Type: application/json');
echo json_encode(getCandidatos());
