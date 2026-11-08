<?php

declare(strict_types=1);

class Conexion
{
    public static function conectar(): PDO
    {
        $config = require __DIR__ . '/database.php';

        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $config['host'],
            $config['port'],
            $config['dbname'],
            $config['charset']
        );

        try {
            return new PDO($dsn, $config['user'], $config['password'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            // El mensaje real puede mostrar el usuario o el servidor: solo va al log.
            error_log('Error de conexión: ' . $e->getMessage());
            throw new RuntimeException('No se pudo conectar con la base de datos.');
        }
    }
}
