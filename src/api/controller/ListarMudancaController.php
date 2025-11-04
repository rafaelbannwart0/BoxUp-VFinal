<?php
session_start();
include_once("../data.trait.php");

$idUsuario = $_SESSION["user"]["id"];
$service = new Service();

$result = $service->BuscarMudancas($idUsuario);

if (!$result["resultado"]) {
    http_response_code(400);
} else {
    foreach ($result["data"] as &$mudanca) {
        $mudanca["hasChat"] = $service->ChatExiste($mudanca["id"]) ? true : false;
    }
}

echo json_encode($result);

