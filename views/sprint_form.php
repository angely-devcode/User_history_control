<?php
require_once __DIR__ . '/../controllers/config/controllers_config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Sprint</title>
    <link rel="stylesheet" href="../public/css/tarjetas.css">
</head>
<body class="pagina-secundaria">
    <div class="contenedor-editorial">
        <nav class="barra-retorno">
            <a href="../index.php" class="btn-volver-pill">← Volver al inicio</a>
        </nav>

        <header class="encabezado-centrado">
            <h1>Crear Nuevo Sprint</h1>
            <div class="linea-ornamental"></div>
        </header>

        <section class="ficha-unica">
            <div class="ficha-cuerpo">
                <h2>Datos del Sprint</h2>
                <form action="actions/create_sprint.php" method="POST" class="formulario-editorial">
                    <div class="campo-grupo">
                        <label for="nombre">Nombre del Sprint</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ej. Módulo de Usuarios" maxlength="100" required>
                    </div>

                    <div class="form-fila-2">
                        <div class="campo-grupo">
                            <label for="fecha_inicio">Fecha de inicio</label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?= date('Y-m-d') ?>" required>
                        </div>

                        <div class="campo-grupo">
                            <label for="fecha_fin">Fecha de finalización</label>
                            <input type="date" id="fecha_fin" name="fecha_fin" required>
                        </div>
                    </div>

                    <div class="acciones-formulario">
                        <button type="submit" class="btn-editorial">Guardar Sprint</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</body>
</html>