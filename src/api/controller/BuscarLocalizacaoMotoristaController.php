<?php
require __DIR__.'/../../config.php';

$motorista_id = $_GET['motorista_id'] ?? 0;

$stmt = $pdo->prepare("SELECT lat, lon FROM localizacoes_motoristas WHERE motorista_id=?");
$stmt->execute([$motorista_id]);
$loc = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($loc);
