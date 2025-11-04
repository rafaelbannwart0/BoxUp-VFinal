<?php
session_start();
include_once("../data.trait.php");

if (!isset($_POST["mudanca_id"])) {
    echo json_encode(["resultado" => false, "mensagem" => "mudanca_id não informado"]);
    exit;
}

$idUsuario = $_SESSION["user"]["id"];
$mudancaId = $_POST["mudanca_id"];

$service = new Service();
$result = $service->CriarChat($mudancaId, $idUsuario);

echo json_encode($result);
