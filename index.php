<?php include 'inc/config.php'; ?>
<?php include 'inc/functions.php'; ?>
<?php
session_start();
$_SESSION['clienteip'] = $_SERVER['REMOTE_ADDR'];
$_SESSION['CONTROL'] = 'S';

setcookie('pagina', $_SERVER['PHP_SELF']);
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
                <form action="page_2.php" method="POST">
                    <br>
                    <h1>Formulario 1</h1><br>
                    <div class="mb-3">
                        <label for="nombre" class="form-label"><strong>Nombre: *</strong></label>
                        <input type="text" class="form-control <?php echo !empty($_SESSION['nombreError']) ? 'input-error' : ''; ?>" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo isset($_SESSION['nombre']) ? $_SESSION['nombre'] : ''; ?>" required>
                        <div class="error-validacion"><?php echo isset($_SESSION['nombreError']) ? $_SESSION['nombreError'] : ''; ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label"><strong>Email: *</strong></label>
                        <input type="email" class="form-control <?php echo !empty($_SESSION['mailError']) ? 'input-error' : ''; ?>" name="email" id="email" placeholder="e-mail" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>
                        <div class="error-validacion"><?php echo isset($_SESSION['mailError']) ? $_SESSION['mailError'] : ''; ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label"><strong>Password: *</strong></label>
                        <input type="password" class="form-control <?php echo !empty($_SESSION['passwordError']) ? 'input-error' : ''; ?>" name="password" id="password" placeholder="Password" value="<?php echo isset($_SESSION['password']) ? $_SESSION['password'] : ''; ?>" required>
                        <div class="error-validacion"><?php echo isset($_SESSION['passwordError']) ? $_SESSION['passwordError'] : ''; ?></div>
                    </div>
                    <button type="submit" value="enviar" id="siguiete" class="btn btn-primary">Siguiente ></button>
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
