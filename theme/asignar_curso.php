<?php
require_once 'db_conexion.php';

header('Content-Type: application/json'); // Muy importante

if (isset($_POST['correo']) && isset($_POST['curso'])) {
    $correo = trim($_POST['correo']);
    $curso = trim($_POST['curso']);

    if (!empty($correo) && !empty($curso)) {
        $query = $cnnPDO->prepare('INSERT INTO cursos (usuario, curso) VALUES (?, ?)');
        $success = $query->execute([$correo, $curso]);

        if ($success) {
            echo json_encode(['status' => 'ok', 'message' => 'Curso asignado.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al insertar.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Campos vacíos.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
}
?>