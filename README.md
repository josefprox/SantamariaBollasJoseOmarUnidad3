# Cursos Data - Plataforma de Administración de Cursos

Cursos Data es una aplicación web desarrollada para administrar y asignar cursos a los usuarios registrados en el sistema. Está diseñada principalmente para instituciones educativas, academias o administradores que necesiten llevar el control de qué cursos están disponibles y cuáles han sido asignados a cada usuario.

---

## Descripción general

La plataforma permite:

- Visualizar usuarios registrados.
- Mostrar los cursos asignados a cada usuario.
- Ver los cursos disponibles en el sistema.
- Asignar nuevos cursos a los usuarios desde un formulario intuitivo.
- Mostrar tarjetas visuales con información clara de cada usuario y sus cursos asignados.

---

## Instalación y uso básico

1. Descarga los archivos del proyecto y colócalos en tu servidor local (por ejemplo, XAMPP, WAMP o MAMP).
2. Configura la conexión a la base de datos en el archivo llamado `db_conexion.php`.
3. Asegúrate de tener una base de datos creada con las tablas necesarias: `usuarios` y `cursos`.
4. Abre el archivo principal del proyecto (como `index.php`) en tu navegador para empezar a utilizar la plataforma.

---

## Requisitos

- Servidor local con PHP (versión 7.4 o superior).
- Base de datos MySQL o MariaDB.
- Navegador web actualizado.

---

## Estructura del sistema

- El sistema cuenta con inicio de sesión y validación de sesión activa.
- Una interfaz para asignar cursos mediante formularios.
- Tarjetas informativas que muestran los cursos por usuario.
- Si un curso no tiene un usuario asignado, se muestra como "Cursos disponibles".
- Diseño responsive adaptado a dispositivos móviles usando Bootstrap.
- Estilos personalizados con énfasis en una interfaz visual moderna.

---

## Tecnologías utilizadas

- PHP para la lógica del servidor.
- MySQL para la base de datos.
- HTML, CSS y Bootstrap para el diseño.
- JavaScript opcional para validaciones o interactividad adicional.
- PHPMailer si se desea incluir funciones de envío de correos.

---

## Licencia

Este proyecto puede ser utilizado y modificado libremente. Las imágenes incluidas (si las hay) son solo demostrativas y podrían requerir licencia para uso comercial.

---

## Autor

Desarrollado como una solución personalizada para la administración educativa. Se puede adaptar según las necesidades de cada institución o plataforma.