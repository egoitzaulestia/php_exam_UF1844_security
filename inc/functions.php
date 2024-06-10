<?php
function recogerVar($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Función para formatear el número de teléfono
function formatearTelefono($telefono) {
    return substr($telefono, 0, 3) . ' ' . substr($telefono, 3, 3) . ' ' . substr($telefono, 6);
}

?>

