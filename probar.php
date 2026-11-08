<?php
require __DIR__ . '/config/conexion.php';

try {
    Conexion::conectar();
    echo 'Conexión correcta';
} catch (RuntimeException $e) {
    echo $e->getMessage();   // solo el mensaje genérico
}
