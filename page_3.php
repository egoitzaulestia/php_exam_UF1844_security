<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'inc/config.php';
include 'inc/functions_B.php';

session_start();
// Comprobamos si el/la usuari@ ha iniciado sesión
if (!isset($_SESSION['clienteip'])) {
    header("location:caducada.html");
    exit;
}

// Inicializamos vacías las variables de error del segundo paso del formulario
$telefonoError = $ciudadError = $fechaNacimientoError = '';

// Inicializamos array con los prefijos de teléfonos en España
$prefijosTel = array('6', '7', '8', '9');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $telefono = recogerVar($_POST['telefono']);
    $ciudad = recogerVar($_POST['ciudad']);
    $dia = recogerVar($_POST['dia']);
    $mes = recogerVar($_POST['mes']);
    $anio = recogerVar($_POST['anio']);
    $fecha_nacimiento = "$anio-$mes-$dia";

    // Validación del teléfono móvil o fijo español
    $telefono = preg_replace('/\D/', '', $telefono); // Eliminamos todo lo que no sea un dígito

    if (empty($telefono)) {
        $telefonoError = "Es obligatorio que introduzca su número de teléfono";
    } elseif (!(strlen($telefono) == 9)) {
        $telefonoError = "El número de teléfono debe contener 9 dígitos";
    } else {
        $prefijoValido = false;
        foreach ($prefijosTel as $prefijo) {
            if ($telefono[0] == $prefijo) {
                $prefijoValido = true;
                break;
            }
        }
        if (!$prefijoValido) {
            $telefonoError = "El número de teléfono debe comenzar por 6, 7, 8 o 9";
        }
    }

    // Validación de ciudad
    function normalizeString($str) {
        $str = strtolower($str);
        $str = preg_replace('/[áàäâ]/u', 'a', $str);
        $str = preg_replace('/[éèëê]/u', 'e', $str);
        $str = preg_replace('/[íìïî]/u', 'i', $str);
        $str = preg_replace('/[óòöô]/u', 'o', $str);
        $str = preg_replace('/[úùüû]/u', 'u', $str);
        $str = preg_replace('/[ç]/u', 'c', $str);
        return $str;
    }

    $ciudadValida = false;
    $municipios = json_decode(file_get_contents('data/municipios.json'), true);
    $ciudadNormalized = normalizeString($ciudad);
    foreach ($municipios as $municipio) {
        if (normalizeString($municipio['nm']) == $ciudadNormalized) {
            $ciudadValida = true;
            $ciudad = $municipio['nm']; // Guardar el nombre correcto con acentos
            break;
        }
    }
    if (!$ciudadValida) {
        $ciudadError = "La ciudad introducida no es válida.";
    }

    // Validación de la fecha de nacimiento
    if (empty($dia) || empty($mes) || empty($anio)) {
        $fechaNacimientoError = "Fecha de Nacimiento es obligatorio";
    } else {
        // Aseguramos que el día y mes tengan dos dígitos y el año tenga cuatro dígitos
        $dia = str_pad($dia, 2, '0', STR_PAD_LEFT);
        $mes = str_pad($mes, 2, '0', STR_PAD_LEFT);
        $anio = str_pad($anio, 4, '0', STR_PAD_LEFT);
        $fecha_nacimiento = "$anio-$mes-$dia";

        $fecha_actual = new DateTime();
        $fecha_nacimiento_dt = DateTime::createFromFormat('Y-m-d', $fecha_nacimiento);
        $errors = DateTime::getLastErrors();

        if ($errors['warning_count'] > 0 || $errors['error_count'] > 0) {
            $fechaNacimientoError = "Fecha de Nacimiento no válida";
        } else {
            $diferencia = $fecha_actual->diff($fecha_nacimiento_dt);
            $edad = $diferencia->y;

            if ($edad < 18) {
                $fechaNacimientoError = "Debes ser mayor de 18 años para enviar el formulario";
            } elseif ($fecha_nacimiento_dt > $fecha_actual) {
                $fechaNacimientoError = "La fecha de nacimiento no puede ser en el futuro";
            }
        }
    }

    if (empty($telefonoError) && empty($ciudadError) && empty($fechaNacimientoError)) {
        $_SESSION['telefono'] = $telefono;
        $_SESSION['ciudad'] = $ciudad;
        $_SESSION['fecha_nacimiento'] = $fecha_nacimiento;
        $_SESSION['dia'] = $dia;
        $_SESSION['mes'] = $mes;
        $_SESSION['anio'] = $anio;
        header("location:page_3.php");
        exit;
    } else {
        $_SESSION['telefono'] = $telefono;
        $_SESSION['ciudad'] = $ciudad;
        $_SESSION['fecha_nacimiento'] = $fecha_nacimiento;
        $_SESSION['dia'] = $dia;
        $_SESSION['mes'] = $mes;
        $_SESSION['anio'] = $anio;

        $_SESSION['telefonoError'] = $telefonoError;
        $_SESSION['ciudadError'] = $ciudadError;
        $_SESSION['fechaNacimientoError'] = $fechaNacimientoError;
        header("location:page_2.php");
        exit;
    }
}

// Función para formatear el número de teléfono
function formatearTelefono($telefono) {
    return substr($telefono, 0, 3) . ' ' . substr($telefono, 3, 3) . ' ' . substr($telefono, 6);
}

// Formatear el teléfono antes de mostrarlo
$telefonoFormateado = isset($_SESSION['telefono']) ? formatearTelefono($_SESSION['telefono']) : '';

?>

<!doctype html>
<html lang="es">

<head>
    <?php include 'inc/head.php'; ?>
    <title><?php echo $sitioTitle . ' - ' . $paginaTitle ?></title>
</head>

<body>
    <div class="container-lg">
        <?php include 'inc/cabecera.php'; ?>
        <?php include 'inc/navegacion.php'; ?>
        <div class="row">
            <?php include 'inc/aside.php'; ?>
            <div class="col-sm-8 col-10" id="Contenido">
                <br>    
                <h1>Revisar Datos</h1><br>
                <p><strong>Nombre:</strong> <?php echo ucfirst($_SESSION['nombre']); ?> <a href="index.php">Editar</a></p>
                <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?> <a href="index.php">Editar</a></p>
                <p><strong>Teléfono:</strong> <?php echo $telefonoFormateado; ?> <a href="page_2.php">Editar</a></p>
                <p><strong>Ciudad:</strong> <?php echo ucfirst($_SESSION['ciudad']); ?> <a href="page_2.php">Editar</a></p>
                <p><strong>Fecha de Nacimiento:</strong> <?php echo $_SESSION['fecha_nacimiento']; ?> <a href="page_2.php">Editar</a></p>
                <form action="page_4.php" method="POST">
                    <button type="submit" class="btn btn-primary">Confirmar Envío</button>
                </form>
                <br>
            </div>
            <?php include 'inc/aside.php'; ?>
        </div>
        <?php include 'inc/footer.php'; ?>
    </div>
    <?php include 'inc/scripts_finales.php'; ?>
</body>

</html>
