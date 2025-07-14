<?php
$utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

define('DB_HOST', 'localhost');
define('DB_NAME', 'cursos');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

try {
    $cnnPDO = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD, $utf8);
} catch (PDOException $e) {
    // Solo mostramos errores en modo desarrollo
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'No se pudo conectar a la base de datos: ' . $e->getMessage()
    ]);
    exit();
}
?>