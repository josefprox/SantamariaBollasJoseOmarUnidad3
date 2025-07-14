<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';
require_once 'db_conexion.php';
session_start();

$alertMessageText = '';
$alertMessageType = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Login normal
    if (isset($_POST['login'])) {
        $usuario = $_POST['usuario'] ?? '';
        $clave = $_POST['clave'] ?? '';

        if (!empty($usuario) && !empty($clave)) {
            $query = $cnnPDO->prepare('SELECT * FROM usuarios WHERE usuario = :user OR correo = :user LIMIT 1');
            $query->bindParam(':user', $usuario);
            $query->execute();
            $userData = $query->fetch(PDO::FETCH_ASSOC);

            if ($userData && password_verify($clave, $userData['clave'])) {
                $_SESSION['usuario'] = $userData['usuario'];
                $_SESSION['correo'] = $userData['correo'];
                $_SESSION['nombre'] = $userData['nombre'];
                $_SESSION['curso'] = $userData['curso'];

                if ($userData['usuario'] === 'admin') {
                    header("location: indexadmin.php");
                } else {
                    header("location: indexusuario.php");
                }
                exit();
            } else {
                $alertMessageText = "Credenciales incorrectas";
                $alertMessageType = "error";
            }
        } else {
            $alertMessageText = "Usuario o contraseña vacíos";
            $alertMessageType = "error";
        }
    }

    // Recuperar contraseña - Generar token y enviar correo
    if (isset($_POST['recuperar'])) {
        $correo = filter_var($_POST['correo'] ?? '', FILTER_SANITIZE_EMAIL);

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $alertMessageText = "Correo inválido";
            $alertMessageType = "error";
        } else {
            // Buscar usuario por correo
            $stmt = $cnnPDO->prepare("SELECT * FROM usuarios WHERE correo = :correo LIMIT 1");
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                $alertMessageText = "Correo no encontrado";
                $alertMessageType = "error";
            } else {
                // Generar token seguro
                $token = bin2hex(random_bytes(16));
                // Guardar token en BD
                $upd = $cnnPDO->prepare("UPDATE usuarios SET token = :token WHERE correo = :correo");
                $upd->bindParam(':token', $token);
                $upd->bindParam(':correo', $correo);
                $upd->execute();

                // Enviar correo con enlace de recuperación
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'josiman280@gmail.com';
                    $mail->Password   = 'wcoswpkuikxryrfd'; // contraseña de aplicación
                    $mail->SMTPSecure = 'tls';
                    $mail->Port       = 587;

                    $mail->setFrom('josiman280@gmail.com', 'Cursos Data');
                    $mail->addAddress($correo, $user['correo']);

                    $mail->isHTML(true);
                    $mail->Subject = 'Recuperar contrasena - Cursos Data';

                    $url_reset = "http://localhost/sh%20u1%20dwp/theme/reset_pass.php?token=$token";

                    $mail->Body = "
                        <div style='font-family: Arial, sans-serif; background:#f5f5f5; padding:30px;'>
                            <div style='max-width:600px; margin:auto; background:#fff; padding:20px; border-radius:8px;'>
                                <h2 style='color:rgb(179, 0, 0); text-align:center;'>Recupera tu contraseña</h2>
                                <p>Hola <b>{$user['correo']}</b>,</p>
                                <p>Haz clic en el siguiente enlace para restablecer tu contraseña:</p>
                                <p><a href='$url_reset' style='color:#d42f2f;'>Restablecer contraseña</a></p>
                                <p>Si no solicitaste este cambio, ignora este correo.</p>
                            </div>
                        </div>";

                    $mail->send();
                    $alertMessageText = "Correo enviado con instrucciones";
                    $alertMessageType = "success";
                } catch (Exception $e) {
                    $alertMessageText = "Error enviando correo: {$mail->ErrorInfo}";
                    $alertMessageType = "error";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <style>
        body { background: #f8f9fa; padding: 2rem; }
        .form-recover { max-width: 400px; margin: auto; background: white; padding: 2rem; border-radius: 0.5rem; }
        .btn-primary {
            background-color: #b30000;
            border-color: #b30000;
        }
        .btn-primary:hover {
            background-color: #8a0000;
            border-color: #8a0000;
        }

        /* Estilos para el toast */
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
.form-recover {
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

/* Efecto hover para el botón */
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

<div class="form-recover">
    <h3 class="mb-4">Recuperar contraseña</h3>

    <form method="POST">
        <div class="form-group mb-3">
            <label for="correo">Correo electrónico registrado</label>
            <input type="email" name="correo" id="correo" class="form-control" placeholder="tuemail@ejemplo.com" required>
        </div>
        <button type="submit" name="recuperar" class="btn btn-primary w-100">Enviar instrucciones</button>
    </form>

    <div class="mt-3 text-center">
        <a href="form.php">Regresar a inicio de sesión</a>
    </div>
</div>

<div id="toast-container"></div>

<script src="js/bootstrap.bundle.min.js"></script>

<script>
    function mostrarToast(mensaje, tipo = 'success') {
        const container = document.getElementById('toast-container');

        const toast = document.createElement('div');
        toast.classList.add('toast', tipo);
        toast.textContent = mensaje;

        container.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOut 0.5s ease forwards';
            toast.addEventListener('animationend', () => {
                toast.remove();
            });
        }, 3000);
    }

    // Mostrar la alerta si viene desde PHP
    window.addEventListener('DOMContentLoaded', () => {
        const mensaje = <?= json_encode($alertMessageText) ?>;
        const tipo = <?= json_encode($alertMessageType) ?>;

        if(mensaje) {
            mostrarToast(mensaje, tipo);
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
        toast.textContent = mensaje;

        container.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOut 0.5s ease forwards';
            toast.addEventListener('animationend', () => {
                toast.remove();
            });
        }, 3000);
    }

    window.addEventListener('DOMContentLoaded', () => {
        const mensaje = <?= json_encode($alertMessageText) ?>;
        const tipo = <?= json_encode($alertMessageType) ?>;

        if(mensaje) {
            mostrarToast(mensaje, tipo);
        }
    });
</script>
</body>
</html>