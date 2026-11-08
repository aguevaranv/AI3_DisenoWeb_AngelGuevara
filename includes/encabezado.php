<?php $paginaActual = basename($_SERVER['SCRIPT_NAME']); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($titulo) ?> | Inventario</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <header class="barra">
        <div class="contenedor barra-contenido">
            <a class="logo" href="index.php">Inventario</a>
            <nav class="menu">
                <a href="index.php" class="<?= $paginaActual === 'index.php' ? 'activo' : '' ?>">Productos</a>
                <a href="crear.php" class="<?= $paginaActual === 'crear.php' ? 'activo' : '' ?>">Registrar</a>
            </nav>
        </div>
    </header>

    <main class="contenedor">
