<?php
require_once __DIR__ . '/../../controllers/config/controllers_config.php';

if (isset($_GET['id'])) {
    $historiasController->deleteHistory($_GET['id']);
}

header('Location: ../../index.php');
exit;