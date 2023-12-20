<?php
//recepción de datos enviados
$nombre = $_POST['nombre-apellido'];
$alias = $_POST['alias'];
$rut = $_POST['rut'];
$email = $_POST['email'];
//verificación en caso de que algún parámetro de entrada tenga NULL como valor si se envía vacío
if (isset($_POST['region'])) {
    $id_region = $_POST['region'];
    if ($id_region !== NULL) {
        validarRegion($id_region, 'err-region');
    }
} else
    $id_region = '';

if (isset($_POST['candidato'])) {
    $id_candidato = $_POST['candidato'];
    if ($id_candidato !== NULL) {
        validarCandidato($id_candidato, 'err-candidato');
    }
} else
    $id_candidato = '';

if (isset($_POST['como-se-entero'])) {
    $comoSeEntero = $_POST['como-se-entero'];
    if ($comoSeEntero !== NULL) {
        validarCheckbox($comoSeEntero, 'err-como-se-entero');
    }
} else
    $comoSeEntero = [];

$id_comuna = $_POST['comuna'];
//validaciones
validarCampo($nombre, 'err-nombre-apellido');
validarAlias($alias, 'err-alias');
validarRut($rut, 'err-rut');
validarEmail($email, 'err-email');
validarRegion($id_region, 'err-region');
validarComuna($id_comuna, 'err-comuna');
validarCandidato($id_candidato, 'err-candidato');
validarCheckbox($comoSeEntero, 'err-como-se-entero');

//función para validar si un campo está vacío
function validarCampo($campo, $mensajeErrorID)
{
    $valor = trim($campo);
    if (empty($valor)) {
        guardarError($mensajeErrorID, 'Este campo no puede estar vacío');
        return false;
    }

    return $valor;
}
//función de validación de nombre
function validarNombre($nombre, $mensajeErrorID)
{
    $valor = validarCampo($nombre, $mensajeErrorID);

}
// verificar que el alias esté compuesto de letras y números, sea mayor a 6 y no tenga carácteres especiales
function validarAlias($alias, $mensajeErrorID)
{
    $valor = validarCampo($alias, $mensajeErrorID);

    if ($valor === false) {
        return false;
    }

    $regex = '/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z0-9]{6,}$/';

    if (preg_match($regex, $valor)) {
        return $valor;
    } else {

        if (preg_match('/[^a-zA-Z0-9]/', $valor)) {
            guardarError($mensajeErrorID, "No se admiten caracteres especiales.");
        } else {
            guardarError($mensajeErrorID, "Se requieren al menos 6 caracteres entre letras y números.");
        }


        return false;
    }
}

//función que valida el formato de rut 11222333-4 su DV y que no esté registrado en la bd 
function validarRut($rut, $mensajeErrorID)
{
    $databaseConfig = array(
        'host' => 'localhost:4306',
        'usuario' => 'root',
        'contrasena' => '',
        'db' => 'votacion_db'
    );
    $valor = validarCampo($rut, $mensajeErrorID);

    if ($valor === false) {
        return false;
    }

    if ($valor !== false) {
        $regex = '/^[0-9]+[-|‐]{1}[0-9kK]{1}$/';

        if (preg_match($regex, $valor)) {
            $dv = strtolower(substr($valor, -1));
            $rutNumeros = substr($valor, 0, -2);
            $suma = 0;
            $multiplo = 2;

            for ($i = strlen($rutNumeros) - 1; $i >= 0; $i--) {
                $suma += $rutNumeros[$i] * $multiplo;
                $multiplo = ($multiplo == 7) ? 2 : $multiplo + 1;
            }
            $resto = $suma % 11;
            $dvCalculado = ($resto == 0) ? 0 : 11 - $resto;
            if (($dv == 'k' && $dvCalculado == 10) || ($dv == $dvCalculado)) {
                // Conexión a la base de datos
                $db = new mysqli($databaseConfig['host'], $databaseConfig['usuario'], $databaseConfig['contrasena'], $databaseConfig['db']);

                if ($db->connect_error) {
                    die("Error de conexión a la base de datos: " . $db->connect_error);
                }
                // Verificar en la base de datos
                $query = "SELECT * FROM votos WHERE rut = ?";
                $stmt = $db->prepare($query);
                $stmt->bind_param("s", $valor);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    // Rut ya registrado en la base de datos
                    guardarError($mensajeErrorID, 'FALSE');// se le asigna FALSE para reconocer que se refiere a que el rut ya está registrado
                    $stmt->close();
                    $db->close();
                    return false;
                } else {
                    return $valor;
                }

                ;
            } else {
                guardarError($mensajeErrorID, 'formáto incorrecto');//Mensaje de error para el formáto
            }
        } else {
            guardarError($mensajeErrorID, 'Rut no válido');// Mensaje de error del DV
        }
    }
    return false;
}
//validar el formáto del email
function validarEmail($email, $mensajeErrorID)
{

    $valor = validarCampo($email, $mensajeErrorID);
    if ($valor === false) {
        return false;
    }
    if ($valor !== false) {
        if (filter_var($valor, FILTER_VALIDATE_EMAIL)) {
            return $valor;
        } else {
            guardarError($mensajeErrorID, 'Correo electrónico no válido');
        }
    }

    return false;
}
//validar que almenos se seleccionen 2 opciones de las checkbox
function validarCheckbox($checkbox, $mensajeErrorID)
{
    $seleccionados = count($checkbox);

    if ($seleccionados < 2) {
        guardarError($mensajeErrorID, 'Debe seleccionar al menos dos opciones');
    } else {

        return $checkbox;
    }

    return false;
}
//validar que se seleccione un candidato y no esté vacío
function validarCandidato($id_candidato, $mensajeErrorID)
{

    $valor = validarCampo($id_candidato, $mensajeErrorID);

    if (!empty($valor)) {
        return $valor;
    } else {
        guardarError($mensajeErrorID, 'Debe seleccionar un candidato');
    }

    return false;
}
//validar que se elija región y no esté vacía
function validarRegion($id_region, $mensajeErrorID)
{

    $valor = validarCampo($id_region, $mensajeErrorID);

    return $valor;
}
//validar que se elija comuna y no esté vacía

function validarComuna($id_comuna, $mensajeErrorID)
{

    $valor = validarCampo($id_comuna, $mensajeErrorID);

    return $valor;
}
// Función que maneja el guardado de errores
function guardarError($mensajeErrorID, $mensaje)
{
    global $errors;
    $errors[$mensajeErrorID] = $mensaje;
}
function guardarValor($dato, $id)
{
    global $valores;
    $valores[$id] = $dato;
}
    //Éxito: registrar el voto en la base de datos y devolver la respuesta JSON
if (empty($errors)) {
    $databaseConfig = array(
        'host' => 'localhost:4306',
        'usuario' => 'root',
        'contrasena' => '',
        'db' => 'votacion_db'
    );

    // Conexión a la base de datos
    $conn = new mysqli($databaseConfig['host'], $databaseConfig['usuario'], $databaseConfig['contrasena'], $databaseConfig['db']);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    $sql = "INSERT INTO votos (nombre_apellido, alias, rut, email, id_region, id_comuna, id_candidato, referencia)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $comoSeEntero = implode(', ', $comoSeEntero);
    $stmt->bind_param("ssssiiis", $nombre, $alias, $rut, $email, $id_region, $id_comuna, $id_candidato, $comoSeEntero);

    if ($stmt->execute()) {
        // Devolver JSON indicando éxito
        echo json_encode(array('success' => 'ok'));
    } else {
        // Devolver JSON con el error
        echo json_encode(array('error' => 'Error al insertar datos: ' . $stmt->error));
    }
    $stmt->close();
    $conn->close();
} else {
    // ERROR: devolver JSON con los errores
    echo json_encode($errors, JSON_UNESCAPED_UNICODE);
}
