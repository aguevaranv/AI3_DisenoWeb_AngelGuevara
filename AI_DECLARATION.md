# Declaración de uso de Inteligencia Artificial

**Proyecto:** Inventario de Productos - Actividad Integradora 3  
**Estudiante:** Angel Mauricio Guevara Chinchero  
**Materia:** Programación de Sistemas Web - Universidad ECOTEC

## 1. ¿Qué herramientas de IA utilicé y en qué momentos?

Utilicé **Claude (Anthropic)** en estos momentos:

| Momento | Para qué la usé |
|---|---|
| Antes de empezar | Le pedí que desarrollara la actividad completa y una guía para hacerla desde cero. Me entregó una aplicación de referencia terminada (PHP + PDO + MySQL) y una guía en PDF dividida en 7 etapas, una por commit, con la investigación PDO vs MySQLi, el código explicado y cómo probar cada etapa. |
| Desarrollo (etapas 1 a 6) | Construí el proyecto siguiendo la guía etapa por etapa y usando el código de la versión de referencia. |
| Pruebas y evidencias | Ejecuté el proyecto en mi XAMPP, creé la base de datos en phpMyAdmin, registré productos de prueba y tomé yo mismo las capturas del informe. |
| Documentación | La IA redactó el `README.md`, el diagrama de arquitectura y el borrador del informe técnico (usando mi informe de la Actividad 2 como plantilla y mis capturas), y esta declaración. Yo los revisé antes de entregarlos. |

## 2. Prompts clave utilizados

1. > "Ayúdame a hacer la Actividad Integradora 3, desarrolla la actividad completa y crea una guía para hacerla desde cero."

2. > "Escribe el README.md, el proyecto está donde me recomendaste: C:\xampp\htdocs\AI3_DisenoWeb_AngelGuevara"

3. > "Ayúdame a desarrollar el informe técnico en formato docx AI3_Informe_NombreApellido.docx. Utiliza el Informe_Act2_Angel_Guevara.docx como plantilla y utiliza las imágenes de la carpeta img."

4. > "Ahora ayúdame a crear el AI_DECLARATION.md"

## 3. ¿Qué partes del código sugerido contenían errores o requirieron ajustes manuales?

1. **Columna de código cortada.** Al probar la versión de referencia, la IA detectó que en la tabla los códigos se partían en dos líneas ("HOG-" / "001"). Lo corrigió con `white-space: nowrap` en la primera y la última columna antes de entregarme el código.

2. **Validación de `minlength` en el navegador.** `minlength` solo se revisa cuando el usuario teclea, y `required` acepta un nombre formado solo por espacios. Por eso el proyecto no depende del navegador: `validarProducto()` vuelve a validar todo en PHP con `trim()` y `mb_strlen()`.

3. **Archivo de credenciales.** `config/database.php` no se sube a GitHub (está en el `.gitignore`). Tuve que crearlo yo copiando `database.example.php`, como indica el README.

4. **Archivo de prueba de conexión.** La guía proponía `probar.php` como prueba temporal. Lo dejé en el repositorio porque solo muestra "Conexión correcta" o el mensaje genérico, sin datos sensibles.

5. **Capturas del informe.** El primer borrador del informe dejó espacios vacíos para el formulario y la tabla, porque las capturas de la guía eran de la versión de referencia y no de mi proyecto. Tomé las capturas de mi propio `localhost` y después se agregaron al informe.

6. **Historial de commits.** El formulario de registro (`crear.php` y el método `registrar()`) quedó dentro del commit "Validación en el cliente y diseño responsivo" en lugar de tener un commit propio, y los primeros mensajes no usan los prefijos `feat:` / `docs:`.

## 4. Reflexión

La IA me dio el proyecto y una guía para entenderlo, así que mi trabajo principal fue armarlo por etapas, ejecutarlo en mi entorno, probarlo y documentarlo. Lo más importante que aprendí fue por qué las sentencias preparadas evitan la inyección SQL (el SQL y los datos viajan por separado), por qué toda salida debe pasar por `htmlspecialchars()` y por qué la validación del navegador no reemplaza a la del servidor. También entendí la importancia de mantener las credenciales fuera del repositorio con el `.gitignore`.
