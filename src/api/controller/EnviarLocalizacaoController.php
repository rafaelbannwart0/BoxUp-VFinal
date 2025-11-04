<?php
session_start();
require __DIR__.'/../../config.php';

$motorista_id = $_SESSION['user']['id'] ?? 0;
$lat = $_POST['lat'] ?? null;
$lon = $_POST['lon'] ?? null;

if (!$motorista_id || !$lat || !$lon) {
    echo json_encode(['success' => false, 'msg' => 'Dados inválidos']);
    exit;
}

// Verifica se já existe registro do motorista
$stmt = $pdo->prepare("SELECT id FROM localizacoes_motoristas WHERE motorista_id=?");
$stmt->execute([$motorista_id]);

if ($stmt->rowCount() > 0) {
    // Atualiza
    $stmt = $pdo->prepare("UPDATE localizacoes_motoristas SET lat=?, lon=?, atualizacao=NOW() WHERE motorista_id=?");
    $stmt->execute([$lat, $lon, $motorista_id]);
} else {
    // Insere
    $stmt = $pdo->prepare("INSERT INTO localizacoes_motoristas (motorista_id, lat, lon) VALUES (?, ?, ?)");
    $stmt->execute([$motorista_id, $lat, $lon]);
}

echo json_encode(['success' => true]);
