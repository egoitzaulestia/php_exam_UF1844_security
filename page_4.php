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
                <br><br>
                <h1>Datos Enviados Correctamente</h1>
                <p><strong>Nombre:</strong> <?php echo ucfirst($_SESSION['nombre']); ?></p>
                <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
                <p><strong>Teléfono:</strong> <?php echo $telefonoFormateado; ?></p>
                <p><strong>Ciudad:</strong> <?php echo ucfirst($_SESSION['ciudad']); ?></p>
                <p><strong>Fecha de Nacimiento:</strong> <?php echo $_SESSION['fecha_nacimiento']; ?></p>
                <br><br>
            </div>
            <?php include 'inc/aside.php'; ?>
        </div>
        <?php include 'inc/footer.php'; ?>
    </div>
    <?php include 'inc/scripts_finales.php'; ?>
</body>

</html>
