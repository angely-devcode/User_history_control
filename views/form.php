<?php
require_once __DIR__ . '/../controllers/config/controllers_config.php';

$grupos = $historiasController->getHistoryGroupedBySprint();

$general = [
    'finalizadas' => 0,
    'pendientes' => 0,
    'impedimentos' => 0,
    'total' => 0
];

$puntos = [
    'finalizadas' => 0,
    'pendientes' => 0,
    'impedimentos' => 0,
    'total' => 0
];

$sprintsPorEstado = [
    'finalizadas' => [],
    'pendientes' => [],
    'impedimentos' => [],
    'total' => []
];

$porResponsable = [];

foreach ($grupos as $grupo) {
    $nombreSprint = trim($grupo['sprint']->nombre);

    foreach ($grupo['historias'] as $h) {
        $pts = (int)$h->puntos;
        $nombreResp = trim($h->responsable);
        if ($nombreResp === '') {
            $nombreResp = 'Sin asignar';
        }
        $claveResp = mb_strtolower($nombreResp);

        if (!isset($porResponsable[$claveResp])) {
            $porResponsable[$claveResp] = [
                'nombre' => $nombreResp,
                'finalizadas' => 0,
                'pendientes' => 0,
                'impedimentos' => 0,
                'total' => 0
            ];
        }

        if ($h->estado === 'finalizada') {
            $campo = 'finalizadas';
        } elseif ($h->estado === 'impedimento') {
            $campo = 'impedimentos';
        } else {
            $campo = 'pendientes';
        }

        $general[$campo]++;
        $general['total']++;

        $puntos[$campo] += $pts;
        $puntos['total'] += $pts;

        $sprintsPorEstado[$campo][$nombreSprint] = $nombreSprint;
        $sprintsPorEstado['total'][$nombreSprint] = $nombreSprint;

        $porResponsable[$claveResp][$campo]++;
        $porResponsable[$claveResp]['total']++;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe</title>
    <link rel="stylesheet" href="../public/css/tarjetas.css">
</head>

<body class="pagina-secundaria">
    <div class="contenedor-informes">
        <nav class="barra-retorno">
            <a href="../index.php" class="btn-volver-pill">← Volver al inicio</a>
        </nav>

        <header class="encabezado-centrado">
            <h1>Informe de Historias de Usuario</h1>
            <div class="linea-ornamental"></div>
        </header>

        <!-- 1. TABLA DEL INFORME GENERAL -->
        <section class="bloque-sprint">
            <h2>Resumen General del Proyecto</h2>
            <div class="sprint-subinfo-centrada">
            </div>

            <?php if ($general['total'] === 0): ?>
                <p style="text-align:center; color: var(--text-secondary); font-size: 13.5px;">
                    Aún no hay historias registradas en el tablero.
                </p>
            <?php else: ?>
                <table class="tabla-informe">
                    <thead>
                        <tr>
                            <th class="col-izquierda">Estado General</th>
                            <th>Cantidad de Historias</th>
                            <th>Puntos</th>
                            <th>Sprints Involucrados</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="col-izquierda">Finalizadas</td>
                            <td><?= $general['finalizadas'] ?></td>
                            <td><?= $puntos['finalizadas'] ?> pts</td>
                            <td><?= !empty($sprintsPorEstado['finalizadas']) ? htmlspecialchars(implode(', ', $sprintsPorEstado['finalizadas'])) : '—' ?></td>
                        </tr>
                        <tr>
                            <td class="col-izquierda">Pendientes (Nuevas y Activas)</td>
                            <td><?= $general['pendientes'] ?></td>
                            <td><?= $puntos['pendientes'] ?> pts</td>
                            <td><?= !empty($sprintsPorEstado['pendientes']) ? htmlspecialchars(implode(', ', $sprintsPorEstado['pendientes'])) : '—' ?></td>
                        </tr>
                        <tr>
                            <td class="col-izquierda">Con Impedimentos</td>
                            <td><?= $general['impedimentos'] ?></td>
                            <td><?= $puntos['impedimentos'] ?> pts</td>
                            <td><?= !empty($sprintsPorEstado['impedimentos']) ? htmlspecialchars(implode(', ', $sprintsPorEstado['impedimentos'])) : '—' ?></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="background-color: var(--glimmer); font-weight: 700;">
                            <td class="col-izquierda">Total General</td>
                            <td><?= $general['total'] ?></td>
                            <td><?= $puntos['total'] ?> pts</td>
                            <td><?= !empty($sprintsPorEstado['total']) ? htmlspecialchars(implode(', ', $sprintsPorEstado['total'])) : '—' ?></td>
                        </tr>
                    </tfoot>
                </table>
            <?php endif; ?>
        </section>

        <!-- 2. TABLA DEL INFORME POR RESPONSABLE -->
        <section class="bloque-sprint">
            <h2>Consolidado por Responsable</h2>
            <div class="sprint-subinfo-centrada">
            </div>

            <?php if (empty($porResponsable)): ?>
                <p style="text-align:center; color: var(--text-secondary); font-size: 13.5px;">
                    Aún no hay responsables con historias asignadas.
                </p>
            <?php else: ?>
                <table class="tabla-informe">
                    <thead>
                        <tr>
                            <th class="col-izquierda">Responsable</th>
                            <th>Finalizadas</th>
                            <th>Pendientes</th>
                            <th>Con Impedimentos</th>
                            <th>Total Asignadas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($porResponsable as $resp): ?>
                            <tr>
                                <td class="col-izquierda"><strong><?= htmlspecialchars($resp['nombre']) ?></strong></td>
                                <td><?= $resp['finalizadas'] ?></td>
                                <td><?= $resp['pendientes'] ?></td>
                                <td><?= $resp['impedimentos'] ?></td>
                                <td><strong><?= $resp['total'] ?></strong></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr style="background-color: var(--glimmer); font-weight: 700;">
                            <td class="col-izquierda">Total General</td>
                            <td><?= $general['finalizadas'] ?></td>
                            <td><?= $general['pendientes'] ?></td>
                            <td><?= $general['impedimentos'] ?></td>
                            <td><?= $general['total'] ?></td>
                        </tr>
                    </tfoot>
                </table>
            <?php endif; ?>
        </section>
    </div>
</body>

</html>