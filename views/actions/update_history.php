<?php
require_once __DIR__ . '/../../controllers/config/controllers_config.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $historiasController->updateHistory($_POST);
}

header('Location: ../../index.php');
exit;