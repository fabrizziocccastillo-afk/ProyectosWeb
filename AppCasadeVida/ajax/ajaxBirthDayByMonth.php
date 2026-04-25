<?php
$actionsRequired = true;
session_start();

require '../controllers/integranteController.php';

$integrante = new integranteController();

$response = $integrante->birthDaysMonth();

echo json_encode($response);