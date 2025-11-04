<?php
session_start();
include_once("../data.trait.php");

$service = new Service();
$mudanca_id = intval($_GET['mudanca_id']);
echo json_encode($service->ListarMensagens($mudanca_id));
