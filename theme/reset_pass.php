<?php
require_once 'db_conexion.php';
session_start();

$alertMessageText = '';
$alertMessageType = '';
$token = $_GET['token'] ?? '';

if (!$token) {
    die("Token inválido.");
}

$stmt = $cnnPDO->prepare("SELECT * FROM usuarios WHERE token = :token LIMIT 1");
$stmt->bindParam(':token', $token);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Token inválido o expirado.");
}

$mostrarFormulario = true;
$redirigir = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevaClave = $_POST['clave1'] ?? '';
    $confirmarClave = $_POST['clave2'] ?? '';

    if (empty($nuevaClave) || empty($confirmarClave)) {
        $alertMessageText = 'Completa ambos campos.';
        $alertMessageType = 'error';
    } elseif ($nuevaClave !== $confirmarClave) {
        $alertMessageText = 'Las contraseñas no coinciden.';
        $alertMessageType = 'error';
    } else {
        $claveHash = password_hash($nuevaClave, PASSWORD_DEFAULT);

        // Actualizar contraseña y limpiar token
        $upd = $cnnPDO->prepare("UPDATE usuarios SET clave = :clave, token = NULL WHERE id = :id");
        $upd->bindParam(':clave', $claveHash);
        $upd->bindParam(':id', $user['id']);
        $upd->execute();

        $alertMessageText = 'Contraseña cambiada correctamente. Redirigiéndote al inicio de sesión...';
        $alertMessageType = 'success';
        $mostrarFormulario = false;
        $redirigir = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Cambiar contraseña</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <style>
        body { background: #f8f9fa; padding: 2rem; }
        .form-reset { max-width: 400px; margin: auto; background: white; padding: 2rem; border-radius: 0.5rem; }

        .btn-primary {
            background-color: #b30000;
            border-color: #b30000;
        }
        .btn-primary:hover {
            background-color: #8a0000;
            border-color: #8a0000;
        }

        /* Toast personalizado */
        #toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 9999;
        }
        .toast {
            min-width: 250px;
            margin-bottom: 0.5rem;
            padding: 1rem 1.5rem;
            border-radius: 4px;
            color: white;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            opacity: 0.95;
            animation: slideIn 0.3s ease forwards;
        }
        .toast.success { background-color: #28a745; }
        .toast.error { background-color: #dc3545; }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 0.95; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 0.95; }
            to { transform: translateX(100%); opacity: 0; }
        }
        .form-group input {
  transition: all 0.3s ease;
  border: 2px solid #ccc;
  border-radius: 8px;
  padding: 10px;
}

.form-group input:hover {
  border-color: #b30000;
  box-shadow: 0 0 8px rgba(179, 0, 0, 0.3);
}

.form-group input:focus {
  border-color: #b30000;
  outline: none;
  background-color: #fff3f3;
}

/* Animación de entrada del formulario */
.form-reset {
  animation: fadeInUp 0.8s ease;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(40px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Efecto visual del botón */
.btn-primary {
  transition: all 0.3s ease;
  transform: scale(1);
}

.btn-primary:hover {
  transform: scale(1.05);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}
    </style>
</head>
<body>

<div class="form-reset">
    <h3 class="mb-4">Restablecer contraseña</h3>

    <?php if ($mostrarFormulario): ?>
    <form method="POST">
        <div class="form-group mb-3">
            <label for="clave1">Nueva contraseña</label>
            <input type="password" name="clave1" id="clave1" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="clave2">Repetir nueva contraseña</label>
            <input type="password" name="clave2" id="clave2" class="form-control" required>
        </div>
        <button type="submit" name="cambiar" class="btn btn-primary w-100">Cambiar contraseña</button>
    </form>
    <?php endif; ?>
</div>

<!-- Toast container -->
<div id="toast-container"></div>

<script>
    function mostrarToast(mensaje, tipo = 'success') {
        const container = document.getElementById('toast-container');

        const toast = document.createElement('div');
        toast.classList.add('toast', tipo);
        toast.innerHTML = mensaje;

        container.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOut 0.5s ease forwards';
            toast.addEventListener('animationend', () => {
                toast.remove();
            });
        }, 3000);
    }

    // Mostrar mensaje si se generó en PHP
    window.addEventListener('DOMContentLoaded', () => {
        const mensaje = <?= json_encode($alertMessageText) ?>;
        const tipo = <?= json_encode($alertMessageType) ?>;
        const redirigir = <?= json_encode($redirigir) ?>;

        if (mensaje) {
            mostrarToast(mensaje, tipo);
        }

        if (redirigir) {
            setTimeout(() => {
                window.location.href = 'form.php';
            }, 3000);
        }
    });
</script>
<script>
    // Efecto de foco en campos con interacción visual
    const campos = document.querySelectorAll('.form-control');

    campos.forEach(input => {
        input.addEventListener('focus', () => {
            input.style.backgroundColor = '#fff5f5';
        });
        input.addEventListener('blur', () => {
            input.style.backgroundColor = '';
        });
    });

    function mostrarToast(mensaje, tipo = 'success') {
        const container = document.getElementById('toast-container');

        const toast = document.createElement('div');
        toast.classList.add('toast', tipo);
        toast.innerHTML = mensaje;

        container.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOut 0.5s ease forwards';
            toast.addEventListener('animationend', () => {
                toast.remove();
            });
        }, 3000);
    }

    // Mostrar mensaje desde PHP
    window.addEventListener('DOMContentLoaded', () => {
        const mensaje = <?= json_encode($alertMessageText) ?>;
        const tipo = <?= json_encode($alertMessageType) ?>;
        const redirigir = <?= json_encode($redirigir) ?>;

        if (mensaje) {
            mostrarToast(mensaje, tipo);
        }

        if (redirigir) {
            setTimeout(() => {
                window.location.href = 'form.php';
            }, 3000);
        }
    });
</script>
</body>
</html>
