<?php
session_start();

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['campo']) && isset($data['valor'])) {
    $campo = $data['campo'];
    $valor = $data['valor'];

    $_SESSION[$campo] = $valor;

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>