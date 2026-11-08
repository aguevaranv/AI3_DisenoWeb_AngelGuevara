<?php

declare(strict_types=1);

require __DIR__ . '/config/conexion.php';
require __DIR__ . '/models/Producto.php';
require __DIR__ . '/includes/funciones.php';

session_start();

$datos = [
    'codigo'      => '',
    'nombre'      => '',
    'categoria'   => '',
    'precio'      => '',
    'stock'       => '',
    'descripcion' => '',
];
$errores = [];
$errorGeneral = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$datos, $errores] = validarProducto($_POST);

    if ($errores === []) {
        try {
            $modelo = new Producto(Conexion::conectar());

            if ($modelo->existeCodigo($datos['codigo'])) {
                $errores['codigo'] = 'Ya existe un producto con ese código.';
            } else {
                $modelo->registrar($datos);

                // Patrón POST-Redirect-GET: al recargar no se vuelve a enviar el formulario.
                $_SESSION['mensaje'] = 'Producto "' . $datos['nombre'] . '" registrado correctamente.';
                header('Location: index.php', true, 303);
                exit;
            }
        } catch (PDOException | RuntimeException $e) {
            error_log('Error al registrar producto: ' . $e->getMessage());
            $errorGeneral = 'No se pudo guardar el producto. Intenta más tarde.';
        }
    }

    http_response_code($errorGeneral !== '' ? 500 : 422);
}

$titulo = 'Registrar producto';
require __DIR__ . '/includes/encabezado.php';
?>
        <section class="cabecera-seccion">
            <div>
                <h1><?= e($titulo) ?></h1>
                <p class="subtitulo">Los campos con * son obligatorios.</p>
            </div>
            <a class="boton boton-secundario" href="index.php">Ver productos</a>
        </section>

        <?php if ($errorGeneral !== ''): ?>
            <p class="alerta alerta-error"><?= e($errorGeneral) ?></p>
        <?php elseif ($errores !== []): ?>
            <p class="alerta alerta-error">Revisa los campos marcados en rojo.</p>
        <?php endif; ?>

        <form id="form-producto" class="formulario" action="crear.php" method="post" novalidate>
            <div class="fila">
                <div class="campo">
                    <label for="codigo">Código *</label>
                    <input type="text" id="codigo" name="codigo" value="<?= e($datos['codigo']) ?>"
                           placeholder="ABC-123" required pattern="[A-Z]{3}-[0-9]{3}" maxlength="7"
                           data-error="El código debe tener el formato ABC-123.">
                    <?= errorDe($errores, 'codigo') ?>
                </div>

                <div class="campo">
                    <label for="categoria">Categoría *</label>
                    <select id="categoria" name="categoria" required
                            data-error="Selecciona una categoría de la lista.">
                        <option value="">-- Selecciona --</option>
                        <?php foreach (Producto::CATEGORIAS as $categoria): ?>
                            <option value="<?= e($categoria) ?>" <?= $datos['categoria'] === $categoria ? 'selected' : '' ?>>
                                <?= e($categoria) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?= errorDe($errores, 'categoria') ?>
                </div>
            </div>

            <div class="campo">
                <label for="nombre">Nombre *</label>
                <input type="text" id="nombre" name="nombre" value="<?= e($datos['nombre']) ?>"
                       required minlength="3" maxlength="80"
                       data-error="El nombre debe tener entre 3 y 80 caracteres.">
                <?= errorDe($errores, 'nombre') ?>
            </div>

            <div class="fila">
                <div class="campo">
                    <label for="precio">Precio (USD) *</label>
                    <input type="number" id="precio" name="precio" value="<?= e($datos['precio']) ?>"
                           required min="0.01" max="99999999.99" step="0.01"
                           data-error="El precio debe ser mayor que 0 y tener máximo 2 decimales.">
                    <?= errorDe($errores, 'precio') ?>
                </div>

                <div class="campo">
                    <label for="stock">Stock *</label>
                    <input type="number" id="stock" name="stock" value="<?= e($datos['stock']) ?>"
                           required min="0" max="100000" step="1"
                           data-error="El stock debe ser un número entero entre 0 y 100000.">
                    <?= errorDe($errores, 'stock') ?>
                </div>
            </div>

            <div class="campo">
                <label for="descripcion">Descripción (opcional)</label>
                <textarea id="descripcion" name="descripcion" rows="3" maxlength="255"
                          data-error="La descripción admite máximo 255 caracteres."><?= e($datos['descripcion']) ?></textarea>
                <?= errorDe($errores, 'descripcion') ?>
            </div>

            <div class="acciones">
                <button type="submit" class="boton">Guardar producto</button>
                <button type="reset" class="boton boton-secundario">Limpiar</button>
            </div>
        </form>

        <script src="js/validacion.js"></script>
<?php require __DIR__ . '/includes/pie.php'; ?>
