<?php
session_start();
include_once("../data.trait.php");

$idUsuario = $_SESSION["user"]["id"];
$service = new Service();

$result = $service->BuscarMudancasMotoristasVisiveis($idUsuario);

echo json_encode($result);
