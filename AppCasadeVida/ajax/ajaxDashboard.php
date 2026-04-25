<?php
$actionsRequired = true;
session_start();

require '../controllers/integranteController.php';

$integrante = new integranteController();

$response = $integrante->integranteCount();

echo $response;