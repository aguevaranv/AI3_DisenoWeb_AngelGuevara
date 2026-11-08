CREATE DATABASE IF NOT EXISTS db_sistema_web
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE db_sistema_web;

CREATE TABLE IF NOT EXISTS productos (
    id             INT UNSIGNED   NOT NULL AUTO_INCREMENT,
    codigo         VARCHAR(7)     NOT NULL,
    nombre         VARCHAR(80)    NOT NULL,
    categoria      VARCHAR(30)    NOT NULL,
    precio         DECIMAL(10, 2) NOT NULL,
    stock          INT UNSIGNED   NOT NULL DEFAULT 0,
    descripcion    VARCHAR(255)   NULL,
    fecha_creacion TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_productos_codigo (codigo)
) ENGINE = InnoDB;
