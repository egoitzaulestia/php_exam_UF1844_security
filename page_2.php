<?php include 'inc/config.php'; ?>
<?php include 'inc/functions.php'; ?>
<?php
session_start();
// Comprobamos si el/la usuari@ ha inciado sesión
if (!isset($_SESSION['clienteip'])) {
    header("location:caducada.html");
    exit;
}

// Inicializamos vacías las variables de error del primer paso del formulario
$nombreError = $mailError = $passwordError = '';

// Limpiar errores anteriores
unset($_SESSION['telefonoError'], $_SESSION['ciudadError'], $_SESSION['fechaNacimientoError']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = recogerVar($_POST['nombre']);
    $email = recogerVar($_POST['email']);
    $password = recogerVar($_POST['password']);

    if (empty($nombre)) {
        $nombreError = "Nombre es obligatorio";
    } elseif (strlen($nombre) < 2) {
        $nombreError = "El nombre no puede contener solo un carácter";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mailError = "Email incorrecto";
    }

    $regexPassword = '/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/';

    if (!preg_match($regexPassword, $password)) {
        $passwordError = "La contraseña debe tener al menos 8 caracteres, incluyendo una letra minúscula, una letra mayúscula y un número.";
    }

    if (empty($nombreError) && empty($mailError) && empty($passwordError)) {
        $_SESSION['nombre'] = $nombre;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        header("location:page_2.php");
        exit;
    } else {
        $_SESSION['nombre'] = $nombre;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;

        $_SESSION['nombreError'] = $nombreError;
        $_SESSION['mailError'] = $mailError;
        $_SESSION['passwordError'] = $passwordError;

        header("location:index.php");
        exit;
    }
}
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
                <form action="page_3.php" method="POST">
                    <br>
                    <h1>Formulario 2</h1><br>
                    <div class="mb-3">
                        <label for="telefono" class="form-label"><strong>Teléfono: *</strong></label>
                        <input type="tel" class="form-control <?php echo !empty($_SESSION['telefonoError']) ? 'input-error' : ''; ?>" name="telefono" id="telefono" placeholder="Telefono" value="<?php echo isset($_SESSION['telefono']) ? $_SESSION['telefono'] : ''; ?>" required>
                        <div class="error-validacion"><?php echo isset($_SESSION['telefonoError']) ? $_SESSION['telefonoError'] : ''; ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="ciudad" class="form-label"><strong>Ciudad: *</strong></label>
                        <input type="text" class="form-control <?php echo !empty($_SESSION['ciudadError']) ? 'input-error' : ''; ?>" name="ciudad" id="ciudad" placeholder="Ciudad" value="<?php echo isset($_SESSION['ciudad']) ? $_SESSION['ciudad'] : ''; ?>" required>
                        <div class="error-validacion"><?php echo isset($_SESSION['ciudadError']) ? $_SESSION['ciudadError'] : ''; ?></div>
                        <div class="suggestions sugerencia"></div>
                    </div>
 
                    <div class="mb-3">
                        <label for="fecha_nacimiento" class="form-label"><strong>Fecha de Nacimiento: *</strong></label>
                        <div class="fecha-nacimiento">
                            <select name="dia" id="dia" class="form-control">
                                <?php for ($i = 1; $i <= 31; $i++) : ?>
                                    <option value="<?php echo $i; ?>" <?php echo (isset($_SESSION['dia']) && $_SESSION['dia'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                            <select name="mes" id="mes" class="form-control">
                                <?php
                                $meses = array(
                                    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                                    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                                    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                                );
                                foreach ($meses as $num => $nombre) : ?>
                                    <option value="<?php echo $num; ?>" <?php echo (isset($_SESSION['mes']) && $_SESSION['mes'] == $num) ? 'selected' : ''; ?>><?php echo $nombre; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select name="anio" id="anio" class="form-control">
                                <?php
                                $currentYear = date('Y');
                                for ($i = $currentYear; $i >= 1900; $i--) : ?>
                                    <option value="<?php echo $i; ?>" <?php echo (isset($_SESSION['anio']) && $_SESSION['anio'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="error-validacion"><?php echo isset($_SESSION['fechaNacimientoError']) ? $_SESSION['fechaNacimientoError'] : ''; ?></div>
                    </div>
                    <button type="submit" value="enviar" id="siguiente" class="btn btn-primary">Siguiente ></button>
                </form>
                <br>
            </div>
            <?php include 'inc/aside.php'; ?>
        </div>
        <?php include 'inc/footer.php'; ?>
    </div>
    <?php include 'inc/scripts_finales.php'; ?>
    <script src="js/script.js"></script>
</body>

</html>