<?php
// 1. Conexión a la base de datos
require_once __DIR__ . '/../../models/config/models_config.php';

// 2. Entidades (moldes)
require_once __DIR__ . '/../../models/entities/sprint.php';
require_once __DIR__ . '/../../models/entities/history.php';

// 3. Mappers del modelo
require_once __DIR__ . '/../../models/mappers/sprints_mappers.php';
require_once __DIR__ . '/../../models/mappers/history_mappers.php';

// 4. Acceso a base de datos (SQL)
require_once __DIR__ . '/../../models/database/sprints_db_interface.php';
require_once __DIR__ . '/../../models/database/sprints_db.php';
require_once __DIR__ . '/../../models/database/history_db_interface.php';
require_once __DIR__ . '/../../models/database/history_db.php';

// 5. Repositorios
require_once __DIR__ . '/../../models/repositories/sprints_repository_interface.php';
require_once __DIR__ . '/../../models/repositories/sprints_repository.php';
require_once __DIR__ . '/../../models/repositories/history_repository_interface.php';
require_once __DIR__ . '/../../models/repositories/history_repository.php';

// 6. Mappers de controladores
require_once __DIR__ . '/../mappers/sprints_mappers.php';
require_once __DIR__ . '/../mappers/history_mappers.php';

// 7. Controladores
require_once __DIR__ . '/../sprints/sprints_controller_interface.php';
require_once __DIR__ . '/../sprints/sprints_controller.php';
require_once __DIR__ . '/../history/history_controller_interface.php';
require_once __DIR__ . '/../history/history_controller.php';

// 8. Inicialización lista para usar en las vistas
$conexion = conectarDB();

$sprintsDb = new SprintsDb($conexion);
$historiasDb = new HistoryDb($conexion);

$sprintsRepository = new SprintsRepository($sprintsDb);
$historiasRepository = new HistoryRepository($historiasDb);

$sprintsController = new SprintsController($sprintsRepository);
$historiasController = new HistoryController($historiasRepository, $sprintsRepository);