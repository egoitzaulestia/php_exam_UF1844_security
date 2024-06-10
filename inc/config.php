<?php
$sitioNombre = 'Examen del Módulo UF1844 - PHP';
$sitioTitle = 'UF1844 - PHP';
$alumno = "Egoitz Aulestia";
$paginaTitle = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);

function active($page) {
    $current_page = basename($_SERVER['PHP_SELF']);
    return $current_page == $page ? 'active' : '';
}

$url_github = 'https://github.com/egoitzaulestia';
$url_linkedin = 'https://es.linkedin.com/company/neural-interface-technologies';
$infoEmail = 'info@neuralinterfacetechnologies.com';
?>
