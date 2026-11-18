<?php
require_once __DIR__ . '/../controllers/config/controllers_config.php';

$sprints = $sprintsController->getAllSprints();
$historiaEditar = null;
$sprintPreseleccionado = isset($_GET['sprint_id']) ? (int)$_GET['sprint_id'] : null;

if (isset($_GET['id'])) {
    $historiaEditar = $historiasController->getHistoryById($_GET['id']);
}

$esEdicion = ($historiaEditar !== null);
$accionFormulario = $esEdicion ? 'actions/update_history.php' : 'actions/create_history.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $esEdicion ? 'Editar Historia' : 'Nueva Historia' ?></title>
    <link rel="stylesheet" href="../public/css/tarjetas.css">
</head>
<body class="pagina-secundaria">
    <div class="contenedor-editorial">
        <nav class="barra-retorno">
            <a href="../index.php" class="btn-volver-pill">← Volver al inicio</a>
        </nav>

        <header class="encabezado-centrado">
            <h1><?= $esEdicion ? 'Editar Historia de Usuario' : 'Registrar Historia de Usuario' ?></h1>
            <div class="linea-ornamental"></div>
        </header>

        <section class="ficha-unica">
            <div class="ficha-cuerpo">
                <h2><?= $esEdicion ? 'Modificar Datos de la Historia' : 'Especificación de la Historia' ?></h2>

                <?php if (empty($sprints)): ?>
                    <div class="aviso">
                        Aún no hay sprints registrados. <a href="formulario_sprint.php"><strong>Crea un sprint aquí</strong></a> antes de registrar una historia.
                    </div>
                <?php endif; ?>

                <form action="<?= $accionFormulario ?>" method="POST" class="formulario-editorial">
                    <?php if ($esEdicion): ?>
                        <input type="hidden" name="id" value="<?= $historiaEditar->id ?>">
                    <?php endif; ?>

                    <div class="form-fila-2">
                        <div class="campo-grupo">
                            <label for="sprint_id">Sprint asignado</label>
                            <select id="sprint_id" name="sprint_id" required>
                                <option value="">-- Selecciona un sprint --</option>
                                <?php foreach ($sprints as $sp): ?>
                                    <?php
                                    $seleccionado = ($esEdicion && $historiaEditar->sprint_id == $sp->id)
                                                 || (!$esEdicion && $sprintPreseleccionado === (int)$sp->id);
                                    ?>
                                    <option value="<?= $sp->id ?>" <?= $seleccionado ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($sp->nombre) ?> (<?= $sp->fecha_inicio ?> a <?= $sp->fecha_fin ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="campo-grupo">
                            <label for="fecha_creacion">Fecha de registro</label>
                            <input type="date" id="fecha_creacion" name="fecha_creacion" required
                                   value="<?= $esEdicion ? htmlspecialchars($historiaEditar->fecha_creacion) : date('Y-m-d') ?>">
                        </div>
                    </div>

                    <div class="campo-grupo">
                        <label for="titulo">Título de la historia</label>
                        <input type="text" id="titulo" name="titulo" maxlength="150" placeholder="Ej. Implementar inicio de sesión" required
                               value="<?= $esEdicion ? htmlspecialchars($historiaEditar->titulo) : '' ?>">
                    </div>

                    <div class="campo-grupo">
                        <label for="descripcion">Descripción y criterios</label>
                        <textarea id="descripcion" name="descripcion" rows="3" placeholder="Describe qué se debe lograr en esta historia..." required><?= $esEdicion ? htmlspecialchars($historiaEditar->descripcion) : '' ?></textarea>
                    </div>

                    <div class="form-fila-3">
                        <div class="campo-grupo">
                            <label for="responsable">Responsable</label>
                            <input type="text" id="responsable" name="responsable" maxlength="100" placeholder="Nombre" required
                                   value="<?= $esEdicion ? htmlspecialchars($historiaEditar->responsable) : '' ?>">
                        </div>

                        <div class="campo-grupo">
                            <label for="puntos">Puntos</label>
                            <input type="number" id="puntos" name="puntos" min="1" max="100" required
                                   value="<?= $esEdicion ? (int)$historiaEditar->puntos : 1 ?>">
                        </div>

                        <div class="campo-grupo">
                            <label for="estado">Estado actual</label>
                            <?php $estadoActual = $esEdicion ? $historiaEditar->estado : 'nueva'; ?>
                            <select id="estado" name="estado" required>
                                <option value="nueva" <?= $estadoActual === 'nueva' ? 'selected' : '' ?>>Nueva</option>
                                <option value="activa" <?= $estadoActual === 'activa' ? 'selected' : '' ?>>Activa</option>
                                <option value="finalizada" <?= $estadoActual === 'finalizada' ? 'selected' : '' ?>>Finalizada</option>
                                <option value="impedimento" <?= $estadoActual === 'impedimento' ? 'selected' : '' ?>>En impedimento</option>
                            </select>
                        </div>
                    </div>

                    <div class="acciones-formulario">
                        <button type="submit" class="btn-editorial" <?= empty($sprints) ? 'disabled' : '' ?>>
                            <?= $esEdicion ? 'Guardar Cambios' : 'Registrar Historia' ?>
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</body>
</html>