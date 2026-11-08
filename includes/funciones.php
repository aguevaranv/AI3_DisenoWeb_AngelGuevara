<?php

declare(strict_types=1);

// Escapa un texto antes de mostrarlo en HTML (protección contra XSS).
function e(?string $valor): string
{
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}

// Lee un campo del formulario como texto, aunque no exista o llegue como arreglo.
function campoTexto(array $entrada, string $campo): string
{
    $valor = $entrada[$campo] ?? '';

    return is_string($valor) ? trim($valor) : '';
}

// Etiqueta donde se muestra el error de un campo (vacía si no hay error).
function errorDe(array $errores, string $campo): string
{
    return '<small class="error-campo">' . e($errores[$campo] ?? '') . '</small>';
}

// Valida los datos del producto en el servidor. Devuelve [datos limpios, errores].
function validarProducto(array $entrada): array
{
    $datos = [
        'codigo'      => strtoupper(campoTexto($entrada, 'codigo')),
        'nombre'      => campoTexto($entrada, 'nombre'),
        'categoria'   => campoTexto($entrada, 'categoria'),
        'precio'      => campoTexto($entrada, 'precio'),
        'stock'       => campoTexto($entrada, 'stock'),
        'descripcion' => campoTexto($entrada, 'descripcion'),
    ];
    $errores = [];

    if (!preg_match('/^[A-Z]{3}-\d{3}$/', $datos['codigo'])) {
        $errores['codigo'] = 'El código debe tener el formato ABC-123.';
    }

    $largoNombre = mb_strlen($datos['nombre']);
    if ($largoNombre < 3 || $largoNombre > 80) {
        $errores['nombre'] = 'El nombre debe tener entre 3 y 80 caracteres.';
    }

    if (!in_array($datos['categoria'], Producto::CATEGORIAS, true)) {
        $errores['categoria'] = 'Selecciona una categoría de la lista.';
    }

    if (!preg_match('/^\d{1,8}(\.\d{1,2})?$/', $datos['precio']) || (float) $datos['precio'] <= 0) {
        $errores['precio'] = 'El precio debe ser mayor que 0 y tener máximo 2 decimales.';
    }

    $opcionesStock = ['options' => ['min_range' => 0, 'max_range' => 100000]];
    if (filter_var($datos['stock'], FILTER_VALIDATE_INT, $opcionesStock) === false) {
        $errores['stock'] = 'El stock debe ser un número entero entre 0 y 100000.';
    }

    if (mb_strlen($datos['descripcion']) > 255) {
        $errores['descripcion'] = 'La descripción admite máximo 255 caracteres.';
    }

    return [$datos, $errores];
}
