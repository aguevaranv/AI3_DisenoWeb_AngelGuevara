# Inventario de Productos

**Estudiante:** Angel Mauricio Guevara Chinchero  
**Carrera:** Ingeniería en Sistemas Inteligentes  
**Materia:** Programación de Sistemas Web - Universidad ECOTEC  
**Actividad:** Actividad Integradora 3

Módulo web full-stack en **PHP + MySQL/MariaDB** para registrar y consultar productos. Se conecta a la base de datos con **PDO** y aplica medidas de seguridad contra **inyección SQL** y **XSS**.

## Funcionalidades

- **Registrar productos (Create):** formulario con validación en el cliente (HTML5 + JavaScript) y en el servidor (PHP). Los datos se guardan con **sentencias preparadas**.
- **Consultar productos (Read):** tabla con todos los registros, del más reciente al más antiguo. Cada dato se muestra con `htmlspecialchars()`.
- **Código único:** no permite registrar dos productos con el mismo código (formato `ABC-123`).
- **Mensajes claros:** errores debajo de cada campo y un aviso de confirmación al guardar.
- **Diseño responsivo:** en el celular, cada fila de la tabla se muestra como una tarjeta.

## Tecnologías

- PHP 8 con PDO
- MySQL / MariaDB (XAMPP)
- HTML5, CSS3 y JavaScript
- Git y GitHub

## Estructura del proyecto

```
AI3_DisenoWeb_AngelGuevara/
├── index.php                  Listado de productos (Read)
├── crear.php                  Formulario y registro de productos (Create)
├── probar.php                 Prueba rápida de la conexión
├── config/
│   ├── conexion.php           Clase Conexion: PDO con try-catch
│   ├── database.example.php   Plantilla de credenciales (se sube a GitHub)
│   └── database.php           Credenciales locales (ignorado por Git)
├── models/
│   └── Producto.php           Consultas a la tabla productos
├── includes/
│   ├── funciones.php          Escape de salida y validación del servidor
│   ├── encabezado.php         Cabecera HTML y menú
│   └── pie.php                Pie de página
├── css/
│   └── estilos.css            Estilos y diseño responsivo
├── js/
│   └── validacion.js          Validación en el cliente
└── database/
    └── db_sistema_web.sql     Script DDL de la base de datos
```

## Base de datos

El script `database/db_sistema_web.sql` crea la base `db_sistema_web` y la tabla `productos`:

| Campo | Tipo | Descripción |
|---|---|---|
| `id` | INT UNSIGNED, AUTO_INCREMENT | Clave primaria |
| `codigo` | VARCHAR(7), UNIQUE | Código del producto (`ABC-123`) |
| `nombre` | VARCHAR(80) | Nombre del producto |
| `categoria` | VARCHAR(30) | Electrónica, Hogar, Papelería, Alimentos u Otros |
| `precio` | DECIMAL(10,2) | Precio exacto con 2 decimales |
| `stock` | INT UNSIGNED | Cantidad disponible |
| `descripcion` | VARCHAR(255), NULL | Descripción opcional |
| `fecha_creacion` | TIMESTAMP | Fecha de registro (campo de auditoría, automática) |

## Cómo desplegarlo localmente

**Requisitos:** [XAMPP](https://www.apachefriends.org/es/) (Apache + MySQL/MariaDB y PHP 8) y Git.

1. Clona el repositorio dentro de la carpeta `htdocs` de XAMPP:
   ```bash
   cd C:\xampp\htdocs
   git clone https://github.com/aguevaranv/AI3_DisenoWeb_AngelGuevara.git
   ```
2. Abre el **XAMPP Control Panel** e inicia **Apache** y **MySQL**.
3. Entra a `http://localhost/phpmyadmin`, abre la pestaña **Importar** y selecciona `database/db_sistema_web.sql`. Pulsa **Importar** para crear la base `db_sistema_web` con la tabla `productos`.
4. Crea el archivo de credenciales copiando la plantilla:
   ```bash
   copy config\database.example.php config\database.php
   ```
   Por defecto usa el usuario `root` sin contraseña en `127.0.0.1:3306`, que es la configuración normal de XAMPP. Si MySQL usa otra clave o puerto, cámbialos en `config/database.php`.
5. Comprueba la conexión en `http://localhost/AI3_DisenoWeb_AngelGuevara/probar.php`. Debe mostrar **Conexión correcta**.
6. Abre la aplicación en `http://localhost/AI3_DisenoWeb_AngelGuevara/`.

## Seguridad aplicada

| Riesgo | Medida |
|---|---|
| Inyección SQL | Todas las consultas con datos del usuario usan `prepare()` con marcadores (`:codigo`, `:nombre`…) y `bindValue()` / `execute()`. Los datos nunca se concatenan en el SQL. |
| XSS | Todo dato que se imprime en HTML pasa por la función `e()`, que usa `htmlspecialchars($valor, ENT_QUOTES, 'UTF-8')`. |
| Exposición de credenciales | `config/database.php` está en el `.gitignore`; en GitHub solo está la plantilla `database.example.php`. |
| Mensajes del sistema | Los errores de PDO se registran con `error_log()` y el usuario solo ve un mensaje genérico. |
| Datos inválidos | Se valida en el navegador y otra vez en el servidor; si algo falla, se responde con el código HTTP 422. |
| Reenvío del formulario | Patrón POST-Redirect-GET: después de guardar se redirige con el código 303 para que recargar la página no duplique el registro. |

## ¿Por qué PDO y no MySQLi?

- **Portabilidad:** PDO funciona con MySQL, PostgreSQL, SQLite, SQL Server y otros motores; para cambiar de motor basta con modificar el DSN.
- **Abstracción:** ofrece una sola API orientada a objetos y marcadores con nombre, que hacen las consultas más legibles.
- **Manejo de excepciones:** con `PDO::ERRMODE_EXCEPTION`, cualquier error lanza una `PDOException` que se controla con `try-catch`.
