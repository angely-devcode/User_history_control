<?php
$grupos = $historiasController->getHistoryGroupedBySprint();

$rutaFormHistoria = (basename($_SERVER['SCRIPT_NAME']) === 'index.php')
    ? 'views/formulario_historia.php'
    : 'formulario_historia.php';

date_default_timezone_set('America/Bogota');
$anioActual = (int)date('Y');
$mesActual = (int)date('m');
$diaHoy = (int)date('j');
$diasEnMes = (int)date('t');
$primerDiaSemana = (int)date('N', strtotime("$anioActual-$mesActual-01"));

$meses = [
    1 => 'Enero',
    2 => 'Febrero',
    3 => 'Marzo',
    4 => 'Abril',
    5 => 'Mayo',
    6 => 'Junio',
    7 => 'Julio',
    8 => 'Agosto',
    9 => 'Septiembre',
    10 => 'Octubre',
    11 => 'Noviembre',
    12 => 'Diciembre'
];
$diasSemanaTexto = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
$fechaLegibleHoy = $diasSemanaTexto[(int)date('w')] . ', ' . $diaHoy . ' de ' . strtolower($meses[$mesActual]);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="/User_history_control/public/css/tarjetas.css">
</head>

<body>
    <div class="app-shell">

        <!-- PANEL IZQUIERDO -->
        <aside class="sidebar-izq">
            <div class="perfil-bloque">
                <div class="avatar-circulo">
                    <img src="public/resources/saludorobot.png" alt="Usuario">
                    <circle cx="12" cy="8" r="4"></circle>
                    <path d="M4.5 20c1.6-3.8 4.6-5.5 7.5-5.5s5.9 1.7 7.5 5.5"></path>
                    </svg>
                </div>
                <p class="saludo-board">Bienvenido a tu tablero de tareas</p>
                <span class="sub-saludo">Organiza tus tareas por periodos de trabajo</span>
            </div>

            <nav class="nav-acciones">
                <a href="views/history_form.php" class="btn-nav btn-nav-principal">
                    <span>+</span> Nueva historia
                </a>
                <a href="views/sprint_form.php" class="btn-nav btn-nav-secundario">
                    <span>+</span> Nuevo sprint
                </a>
                <a href="views/form.php" class="btn-nav btn-nav-secundario">
                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 3v18h18"></path>
                        <path d="M18 17V9M13 17V5M8 17v-3"></path>
                    </svg>
                    Generar informe
                </a>
            </nav>
        </aside>
        <main class="board-central">
            <header class="board-header">
                <div>
                    <h1>Seguimiento de historias de usuario por sprints</h1>
                </div>
            </header>

            <?php if (empty($grupos)): ?>
                <div class="estado-vacio">
                    <h3>No hay sprints creados todavía</h3>
                    <p>Crea tu primer sprint desde el menú lateral para empezar a organizar historias de usuario.</p>
                </div>
            <?php endif; ?>

            <?php foreach ($grupos as $grupo): ?>
                <?php $sprint = $grupo['sprint']; ?>
                <section class="sprint-seccion">
                    <div class="sprint-barra">
                        <div class="sprint-titulo-grupo">
                            <h2><?= htmlspecialchars($sprint->nombre) ?></h2>
                            <span class="sprint-fechas">
                                <?= htmlspecialchars($sprint->fecha_inicio) ?> — <?= htmlspecialchars($sprint->fecha_fin) ?>
                            </span>
                        </div>

                        <div class="sprint-acciones-grupo">
                            <a href="views/history_form.php?sprint_id=<?= $sprint->id ?>" class="btn-asignar-sprint">
                                + Asignar historia
                            </a>
                        </div>
                    </div>

                    <?php if (empty($grupo['historias'])): ?>
                        <p class="sprint-sin-tareas">Sin historias asignadas en este sprint.</p>
                    <?php else: ?>
                        <div class="historias-grid">
                            <?php foreach ($grupo['historias'] as $historia): ?>
                                <?php $inicial = mb_strtoupper(mb_substr(trim($historia->responsable), 0, 1)); ?>
                                <article class="historia-card card-estado-<?= htmlspecialchars($historia->estado) ?>">
                                    <div class="card-encabezado">
                                        <span class="pill-estado pill-<?= htmlspecialchars($historia->estado) ?>">
                                            <i class="punto-estado"></i>
                                            <?= ucfirst(htmlspecialchars($historia->estado)) ?>
                                        </span>
                                        <span class="fecha-meta">
                                            <?= !empty($historia->fecha_finalizacion)
                                                ? 'Fin: ' . htmlspecialchars($historia->fecha_finalizacion)
                                                : 'Creada: ' . htmlspecialchars($historia->fecha_creacion) ?>
                                        </span>
                                    </div>

                                    <h3 class="card-titulo"><?= htmlspecialchars($historia->titulo) ?></h3>
                                    <p class="card-desc"><?= nl2br(htmlspecialchars($historia->descripcion)) ?></p>

                                    <div class="card-meta">
                                        <div class="responsable-chip">
                                            <span class="mini-avatar"><?= htmlspecialchars($inicial) ?></span>
                                            <span><?= htmlspecialchars($historia->responsable) ?></span>
                                        </div>
                                        <span class="badge-puntos"><?= (int)$historia->puntos ?> pts</span>
                                    </div>

                                    <div class="card-footer">
                                        <a href="views/history_form.php?id=<?= $historia->id ?>" class="link-accion">Editar</a>
                                        <a href="views/actions/delete_history.php?id=<?= $historia->id ?>"
                                            class="link-accion"
                                            onclick="return confirm('¿Eliminar esta historia de usuario?');">Eliminar</a>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </section>
            <?php endforeach; ?>
        </main>
        <aside class="sidebar-der">
            <div class="widget-calendario">
                <div class="cal-top">
                    <span class="cal-etiqueta">Fecha actual</span>
                    <p class="cal-fecha-hoy"><?= $fechaLegibleHoy ?></p>
                </div>

                <div class="cal-mes-header">
                    <h3><?= $meses[$mesActual] . ' ' . $anioActual ?></h3>
                </div>

                <div class="cal-tabla">
                    <span class="cal-dia-nombre">L</span>
                    <span class="cal-dia-nombre">M</span>
                    <span class="cal-dia-nombre">M</span>
                    <span class="cal-dia-nombre">J</span>
                    <span class="cal-dia-nombre">V</span>
                    <span class="cal-dia-nombre">S</span>
                    <span class="cal-dia-nombre">D</span>

                    <?php for ($i = 1; $i < $primerDiaSemana; $i++): ?>
                        <span class="cal-celda vacia"></span>
                    <?php endfor; ?>

                    <?php for ($dia = 1; $dia <= $diasEnMes; $dia++): ?>
                        <span class="cal-celda <?= ($dia === $diaHoy) ? 'es-hoy' : '' ?>">
                            <?= $dia ?>
                        </span>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="widget-soporte">
                <h3 class="soporte-titulo">¿Tienes alguna duda? ¡Contáctanos!</h3>
                    <img src="public/resources/soporte.png" alt="Soporte" class="soporte-img">
                <a class="soporte-correo">soporte@tutranqui.com</a>
            </div>
        </aside>

    </div>
</body>

</html>