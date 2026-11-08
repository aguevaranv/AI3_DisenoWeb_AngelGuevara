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

}
