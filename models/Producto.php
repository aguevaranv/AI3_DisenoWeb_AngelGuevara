<?php

declare(strict_types=1);

class Producto
{
    public const CATEGORIAS = ['Electrónica', 'Hogar', 'Papelería', 'Alimentos', 'Otros'];

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function listar(): array
    {
        $sql = 'SELECT id, codigo, nombre, categoria, precio, stock, descripcion, fecha_creacion
                FROM productos
                ORDER BY fecha_creacion DESC, id DESC';

        return $this->db->query($sql)->fetchAll();
    }

    public function existeCodigo(string $codigo): bool
    {
        $consulta = $this->db->prepare('SELECT COUNT(*) FROM productos WHERE codigo = :codigo');
        $consulta->execute([':codigo' => $codigo]);

        return (int) $consulta->fetchColumn() > 0;
    }

    public function registrar(array $datos): bool
    {
        $sql = 'INSERT INTO productos (codigo, nombre, categoria, precio, stock, descripcion)
                VALUES (:codigo, :nombre, :categoria, :precio, :stock, :descripcion)';

        $consulta = $this->db->prepare($sql);
        $consulta->bindValue(':codigo', $datos['codigo']);
        $consulta->bindValue(':nombre', $datos['nombre']);
        $consulta->bindValue(':categoria', $datos['categoria']);
        $consulta->bindValue(':precio', $datos['precio']);
        $consulta->bindValue(':stock', (int) $datos['stock'], PDO::PARAM_INT);

        if ($datos['descripcion'] === '') {
            $consulta->bindValue(':descripcion', null, PDO::PARAM_NULL);
        } else {
            $consulta->bindValue(':descripcion', $datos['descripcion']);
        }

        return $consulta->execute();
    }


}
