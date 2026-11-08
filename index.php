<?php

declare(strict_types=1);

require __DIR__ . '/config/conexion.php';
require __DIR__ . '/models/Producto.php';
require __DIR__ . '/includes/funciones.php';

session_start();

// Mensaje que deja crear.php después de guardar (se muestra una sola vez).
$mensaje = $_SESSION['mensaje'] ?? '';
unset($_SESSION['mensaje']);

$productos = [];
$error = '';

try {
    $modelo = new Producto(Conexion::conectar());
    $productos = $modelo->listar();
} catch (PDOException | RuntimeException $e) {
    error_log('Error al listar productos: ' . $e->getMessage());
    $error = 'No se pudieron cargar los productos. Intenta más tarde.';
}

$titulo = 'Productos registrados';
require __DIR__ . '/includes/encabezado.php';
?>
        <section class="cabecera-seccion">
            <div>
                <h1><?= e($titulo) ?></h1>
                <p class="subtitulo"><?= count($productos) ?> producto(s) en la base de datos</p>
            </div>
            <a class="boton" href="crear.php">+ Nuevo producto</a>
        </section>

        <?php if ($mensaje !== ''): ?>
            <p class="alerta alerta-exito"><?= e($mensaje) ?></p>
        <?php endif; ?>

        <?php if ($error !== ''): ?>
            <p class="alerta alerta-error"><?= e($error) ?></p>
        <?php elseif ($productos === []): ?>
            <p class="vacio">Todavía no hay productos. <a href="crear.php">Registra el primero</a>.</p>
        <?php else: ?>
            <div class="tabla-contenedor">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Descripción</th>
                            <th>Registrado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td data-label="Código"><?= e($producto['codigo']) ?></td>
                                <td data-label="Nombre"><?= e($producto['nombre']) ?></td>
                                <td data-label="Categoría"><?= e($producto['categoria']) ?></td>
                                <td data-label="Precio">$<?= number_format((float) $producto['precio'], 2) ?></td>
                                <td data-label="Stock"><?= (int) $producto['stock'] ?></td>
                                <td data-label="Descripción"><?= e($producto['descripcion'] ?? '—') ?></td>
                                <td data-label="Registrado"><?= e(date('d/m/Y H:i', strtotime($producto['fecha_creacion']))) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
<?php require __DIR__ . '/includes/pie.php'; ?>
