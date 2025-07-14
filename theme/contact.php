<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';
require_once 'db_conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');

    // Envío de mensaje por correo
    if (isset($_POST["enviar_correo"])) {
        $nombre = htmlspecialchars(trim($_POST["name"]));
        $correo = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        $mensaje = htmlspecialchars(trim($_POST["message"]));

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'josiman280@gmail.com';
            $mail->Password   = 'wcoswpkuikxryrfd'; // Usa contraseña de aplicación
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom($correo, $nombre);
            $mail->addAddress('josiman280@gmail.com', 'Cursos Data');

            $mail->isHTML(true);
            $mail->Subject = 'Mensaje desde formulario de contacto';
            $mail->Body = '
    <div style="font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 30px;">
        <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
            <h2 style="color:rgb(179, 0, 0); text-align: center;">📨 Nuevo mensaje de contacto</h2>
            <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">
            <p style="font-size: 16px;"><strong>👤 Nombre:</strong> ' . $nombre . '</p>
            <p style="font-size: 16px;"><strong>📧 Correo:</strong> ' . $correo . '</p>
            <p style="font-size: 16px;"><strong>💬 Mensaje:</strong></p>
            <div style="background-color: #f0f0f0; padding: 15px; border-radius: 5px; font-size: 15px; color: #333;">
                ' . nl2br($mensaje) . '
            </div>
            <p style="font-size: 14px; color: #888; margin-top: 30px; text-align: center;">Este mensaje fue enviado desde el formulario de contacto de tu sitio web.</p>
        </div>
    </div>';

            $mail->send();
            echo json_encode(['success' => true, 'message' => '✅ ¡Mensaje enviado correctamente!']);
            exit;
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => '❌ Error al enviar mensaje: ' . $mail->ErrorInfo]);
            exit;
        }
    }

    // Registro de comentario
    if (isset($_POST["registrar"])) {
        $nombre = trim($_POST["nombre"]);
        $correo = trim($_POST["email"]);
        $comentario = trim($_POST["comentario"]);

        if (!empty($nombre) && !empty($correo) && !empty($comentario)) {
            $query = $cnnPDO->prepare("INSERT INTO comentarios (nombre, email, comentario, fecha) VALUES (:nombre, :email, :comentario, NOW())");
            $query->bindParam(':nombre', $nombre);
            $query->bindParam(':email', $correo);
            $query->bindParam(':comentario', $comentario);

            if ($query->execute()) {
                echo json_encode(['success' => true, 'message' => '✅ Comentario registrado correctamente']);
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => '❌ Error al registrar el comentario']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => '⚠️ Todos los campos son obligatorios']);
            exit;
        }
    }
 echo json_encode(['success' => false, 'message' => '⚠️ Acción no válida']);
    exit;
}

// Mostrar comentarios
try {
    $stmt = $cnnPDO->query("SELECT nombre, email, comentario, fecha FROM comentarios ORDER BY fecha DESC");
    $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error al cargar comentarios: " . $e->getMessage() . "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!--
    Basic Page Needs
    ==================================================
    -->
   <meta charset="utf-8">
   <title> Cursos Data</title>
   <!--
    Mobile Specific Metas
    ==================================================
    -->
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
   <!--
    CSS
    ==================================================
    -->
   <!-- Bootstrap-->
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <!-- Animation-->
   <link rel="stylesheet" href="css/animate.css">
   <!-- Morris CSS -->
   <link rel="stylesheet" href="css/morris.css">
   <!-- FontAwesome-->
   <link rel="stylesheet" href="css/font-awesome.min.css">
   <!-- Icon font-->
   <link rel="stylesheet" href="css/icon-font.css">
   <!-- Owl Carousel-->
   <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
   
   <link rel="stylesheet" href="css/owl.carousel.min.css">
   <!-- Owl Theme -->
   <link rel="stylesheet" href="css/owl.theme.default.min.css">
   <!-- Colorbox-->
   <link rel="stylesheet" href="css/colorbox.css">
   <!-- Template styles-->
   <link rel="stylesheet" href="css/style.css">
   <!-- Responsive styles-->
   <link rel="stylesheet" href="css/responsive.css">
   <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file.-->
   <!--if lt IE 9
    script(src='js/html5shiv.js')
    script(src='js/respond.min.js')
    -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
  AOS.init();
</script>
    <style>
      .carousel-inner h2,
      .carousel-inner h3,
      .carousel-inner p {
          color: #000 !important;
      }
      .btn {
    transition: all 0.3s ease;
    border-radius: 8px;
  }

  .btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
  }

  .btn:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(255, 99, 71, 0.3);
  }
  </style>
   <style>
      body {
         font-family: Arial, sans-serif;
         margin: 0;
         padding: 0;
         background-color: #f9f9f9;
      }

      .contact-map {
         display: flex;
         justify-content: center;
         align-items: center;
         padding: 40px 0;
         background-color: #fff;
      }

      .contact-map iframe {
         width: 100%;
         max-width: 900px;
         height: 450px;
         border: 0;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
         border-radius: 10px;
      }
   </style>
   <style>
  #chat-bubble {
    position: fixed;
    bottom: 20px;
    left: 20px;
    background-color: #c62828; /* Rojo fuerte */
    color: white;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    text-align: center;
    font-size: 28px;
    line-height: 60px;
    cursor: pointer;
    z-index: 9999;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    transition: background 0.3s ease;
  }

  #chat-bubble:hover {
    background-color: #b71c1c;
  }

  #chat-box {
    position: fixed;
    bottom: 90px;
    left: 20px;
    width: 300px;
    max-height: 400px;
    background-color: white;
    border: 1px solid #e57373;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    display: flex;
    flex-direction: column;
    z-index: 9999;
  }

  #chat-box.hidden {
    display: none;
  }

  .chat-header {
    background-color: #d32f2f; /* Rojo */
    color: white;
    padding: 12px;
    font-size: 16px;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .chat-body {
    padding: 10px;
    overflow-y: auto;
    height: 200px;
    font-size: 14px;
    flex-grow: 1;
  }

  .chat-input {
    padding: 10px;
    border-top: 1px solid #ddd;
  }

  .chat-input input {
    width: 100%;
    padding: 8px;
    border: 1px solid #e57373;
    border-radius: 5px;
  }

  .user-msg, .bot-msg {
    margin: 6px 0;
    padding: 8px;
    border-radius: 10px;
    max-width: 80%;
    word-wrap: break-word;
  }

  .user-msg {
    background: #ef5350; /* Rojo claro */
    color: white;
    align-self: flex-end;
    margin-left: auto;
    text-align: right;
  }

  .bot-msg {
    background: #fce4ec; /* Rosa muy claro */
    color: #880e4f;
    align-self: flex-start;
    margin-right: auto;
    text-align: left;
  }

  .close-chat {
    cursor: pointer;
    font-size: 20px;
  }
 .ts-feature-box {
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  cursor: pointer;
  border-radius: 12px;
}

.ts-feature-box:hover {
  transform: scale(1.05);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
  background-color: #fefefe;
}

.ts-feature-box img {
  transition: transform 0.4s ease;
}

.ts-feature-box:hover img {
  transform: rotate(3deg) scale(1.1);
}

.percent-area {
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  cursor: pointer;
}

.percent-area:hover {
  transform: scale(1.1);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.banner-title {
  animation: fadeInDown 1.2s ease-in-out;
}

@keyframes fadeInDown {
  0% {
    opacity: 0;
    transform: translateY(-30px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}
.card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border-radius: 15px;
}

.card:hover {
  transform: scale(1.05);
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
}
</style>
</head>

<body>

   <div class="body-inner">

      <div class="site-top-2">
         <header class="header nav-down" id="header-2">
            <div class="container">
               <div class="row">
                  <div class="logo-area clearfix">
                     <div class="logo col-lg-3 col-md-12">
                        <a href="index.html">
                           <img src="images/Cursos.png" alt="">
                        </a>
                     </div>
                     <!-- logo end-->
                     <div class="col-lg-9 col-md-12 pull-right">
                        <ul class="top-info unstyled">
                           <li><span class="info-icon"><i class="icon icon-phone3"></i></span>
                              <div class="info-wrapper">
                                 <p class="info-title">Respuesta inmediata</p>
                                 <p class="info-subtitle">(+52) 844 256 7560</p>
                              </div>
                           </li>
                           <li><span class="info-icon"><i class="icon icon-envelope"></i></span>
                              <div class="info-wrapper">
                                 <p class="info-title">Contactanos</p>
                                 <p class="info-subtitle">josiman280@gmail.com</p>
                              </div>
                           </li>
                           
                        </ul>
                     </div>
                     <!-- Col End-->
                  </div>
                  <!-- Logo Area End-->
               </div>
            </div>
            <!-- Container end-->
            <div class="site-nav-inner site-navigation navigation navdown">
               <div class="container">
                  <nav class="navbar navbar-expand-lg ">
                     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"><i class="icon icon-menu"></i></span></button>
                     <!-- End of Navbar toggler-->
                     <div class="collapse navbar-collapse justify-content-start" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                           <li class="nav-item dropdown">
                                 <a href="index.html">Inicio</a>
                           </li>
                           
                           
                           <!-- li end-->
                           <li class="nav-item dropdown">
                                 <a href="about.html">Sobre nosotros</a>
                           </li>
                           <!-- li end-->
                        
                           <li class="nav-item dropdown">
                                 <a href="service.html">Servicios</a>
                           </li>
                           <!-- li end-->
                           <li class="nav-item dropdown">
                                 <a href="faq.html">Ayuda</a>
                           </li>
                           <!-- li end-->
                           <li class="nav-item dropdown">
                                 <a href="index-2.html">Mapa del sitio</a>
                           </li>
                           <!-- li end-->
                           <li class="nav-item dropdown">
                                 <a href="contact.php">Contáctanos</a>
                           </li>
                        </ul>
                        <!--Nav ul end-->
                     </div>
                     <a href="registro.php" class="top-right-btn btn btn-primary mr-2">Registrarse</a>
                     <a href="form.php" class="top-right-btn btn btn-primary">Iniciar sesión</a>
                  </nav>

                  <!-- Collapse end-->
               </div>
            </div>
            <!-- Site nav inner end-->
         </header>
         <!-- Header end-->
      </div>

      <div class="banner-area" id="banner-area" style="background-image:url(images/banner/ban5.jpg);">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col">
                  <div class="banner-heading">
                     <h1 class="banner-title">Contáctanos y comentarios</h1>
                  </div>
               </div>
               <!-- Col end-->
            </div>
            <!-- Row end-->
         </div>
         <!-- Container end-->
      </div>
      <!-- Banner area end-->
      
      <section class="main-container contact-area" id="main-container">
         <div class="contact-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1801.5912192018432!2d-100.91059416908026!3d25.432163497183367!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x86880ded8485e253%3A0x227c6266447e4a0e!2sImperio%20Mongol%20SN(MZ6%20LT28)%2C%20Puerta%20del%20Oriente%2C%2025016%20Saltillo%2C%20Coah.!5e0!3m2!1ses!2smx!4v1749945140501!5m2!1ses!2smx" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>
         </div>
         <div class="gap-60"></div>
         <div class="ts-form form-boxed" id="ts-form">
            <div class="container">
               <div class="row">
                  <div class="contact-wrapper full-contact">
                     <div class="col-lg-6">
                         <h3 class="column-title">Contáctanos</h3>
                         <p class="contact-content">	Impulsa tu carrera aprendiendo a programar. Ofrecemos cursos prácticos en los lenguajes y tecnologías más demandadas del mercado.</p>
                        <div class="contact-info-box contact-box info-box ">
                           <div class="contact-info">
                              <div class="ts-contact-info"><span class="ts-contact-icon float-left"><i class="icon icon-map-marker2"></i></span>
                                 <div class="ts-contact-content">
                                    <h3 class="ts-contact-title">Encuentranos</h3>
                                    <p>Imperio Mongol Puerta del Oriente, 25016 Saltillo, Coah.</p>
                                 </div>
                                 <!-- Contact content end-->
                              </div>
                              <div class="ts-contact-info"><span class="ts-contact-icon float-left"><i class="icon icon-phone3"></i></span>
                                 <div class="ts-contact-content">
                                    <h3 class="ts-contact-title">Llamanos</h3>
                                    <p>(+52) 844 256 7560</p>
                                 </div>
                                 <!-- Contact content end-->
                              </div>
                              <div class="ts-contact-info last"><span class="ts-contact-icon float-left"><i class="icon icon-envelope"></i></span>
                                 <div class="ts-contact-content">
                                    <h3 class="ts-contact-title">Envianos un mensaje</h3>
                                    <p>josiman280@gmail.com</p>
                                 </div>
                                 <!-- Contact content end-->
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Contact info end -->
                    <div class="col-lg-6">
   <h3 class="column-title">Enviar mensaje por correo</h3>
   <div class="contact-submit-box contact-box form-box">
      <form class="contact-form" id="formCorreo" method="POST">
         <div class="form-group">
            <input class="form-control" name="name" placeholder="Nombre completo" type="text" required>
         </div>
         <div class="form-group">
            <input class="form-control" name="email" placeholder="Correo electrónico" type="email" required>
         </div>
         <div class="form-group">
            <textarea class="form-control" name="message" placeholder="Mensaje" rows="6" required></textarea>
         </div>
         <button class="btn btn-primary" type="submit">
   <i class="fa fa-paper-plane-o"></i> Enviar mensaje
</button>
      </form>
   </div>

   <div class="gap-30"></div>

   <h3 class="column-title">Dejar un comentario</h3>
   <div class="contact-submit-box contact-box form-box">
      <form class="contact-form" id="formComentario" method="POST">
         <div class="form-group">
            <input class="form-control" name="nombre" placeholder="Tu nombre" type="text" required>
         </div>
         <div class="form-group">
            <input class="form-control" name="email" placeholder="Tu correo electrónico" type="email" required>
         </div>
         <div class="form-group">
            <textarea class="form-control" name="comentario" placeholder="Escribe tu comentario" rows="6" required></textarea>
         </div>
         <button class="btn btn-primary" type="submit">
   <i class="fa fa-check"></i> Registrar comentario
</button>
      </form>
   </div>
</div>

   <section class="main-container">
   <div class="container">
      <div class="gap-40"></div>
      <h3 class="column-title">Comentarios de nuestros usuarios</h3>
      <div class="row">
         <?php if (!empty($comentarios)) : ?>
            <?php foreach ($comentarios as $coment) : ?>
               <div class="col-md-6">
                  <div class="card mb-4 shadow-sm" style="border-radius: 10px;">
                     <div class="card-body">
                        <h5 class="card-title">
                           👤 <strong>Nombre:</strong> <?= htmlspecialchars($coment['nombre']) ?>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                           ✉️ <strong>Email:</strong> <?= htmlspecialchars($coment['email']) ?>
                        </h6>
                        <p class="card-text mt-2">
                           💬 <strong>Comentario:</strong><br>
                           <?= nl2br(htmlspecialchars($coment['comentario'])) ?>
                        </p>
                        <p class="card-text">
                           <small class="text-muted">
                              📅 <?= date('d/m/Y H:i', strtotime($coment['fecha'])) ?>
                           </small>
                        </p>
                     </div>
                  </div>
               </div>
            <?php endforeach; ?>
         <?php else : ?>
            <div class="col-12">
               <div class="alert alert-info">Aún no hay comentarios registrados.</div>
            </div>
         <?php endif; ?>
      </div>
   </div>
</section>
   </div>
               </div>
            </div>
         </div>
   </div>
   <!-- Footer start-->
       <div class="copyright">
            <div class="container">
               <div class="row">
                  <div class="col-lg-6 col-md-12">
                     <div class="copyright-info"><span>Copyright © 2025 a theme by Cursos Data</span></div>
                  </div>
                  <div class="col-lg-6 col-md-12">
                    <div class="footer-social text-right">
                        <ul>
                           <li><a href="https://facebook.com"><i class="fa fa-facebook"></i></a></li>
                           <li><a href="https://twitter.com"><i class="fa fa-twitter"></i></a></li>
                           <li><a href="https://plus.google.com"><i class="fa fa-google-plus"></i></a></li>
                           <li><a href="https://github.com"><i class="fa fa-github"></i></a></li>
                           <li><a href="https://instagram.com"><i class="fa fa-instagram"></i></a></li>
                        </ul>
                     </div>
                  </div>
               </div>
               <!-- Row end-->
            </div>
            <!-- Container end-->
         </div>
         <!-- Copyright end-->
          
      </footer>
      <!-- Footer end-->

      <div class="back-to-top affix" id="back-to-top" data-spy="affix" data-offset-top="10">
         <button class="btn btn-primary" title="Back to Top"><i class="fa fa-angle-double-up"></i>
            <!-- icon end-->
         </button>
         <!-- button end-->
      </div>
      <!-- End Back to Top-->

      <!--
      Javascript Files
      ==================================================
      -->
      <!-- initialize jQuery Library-->
      <script type="text/javascript" src="js/jquery.js"></script>
       
       
      <!-- Bootstrap jQuery-->
      <script type="text/javascript" src="js/bootstrap.min.js"></script>
      <!-- Owl Carousel-->
      <script type="text/javascript" src="js/owl.carousel.min.js"></script>
      <!-- Counter-->
      <script type="text/javascript" src="js/jquery.counterup.min.js"></script>
      <!-- Waypoints-->
      <script type="text/javascript" src="js/waypoints.min.js"></script>
      <!-- Color box-->
      <script type="text/javascript" src="js/jquery.colorbox.js"></script>
       
        
      <!-- Google Map API Key-->
      <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU&libraries=places"></script>
      <!-- Google Map Plugin-->
      <script type="text/javascript" src="js/gmap3.js"></script>
      <!-- Template custom-->
      <script type="text/javascript" src="js/custom.js"></script>
   </div>
   <!--Body Inner end-->
   <div id="chat-bubble" onclick="toggleChat()">
  <i class="fa fa-comments"></i>
</div>

<div id="chat-box" class="hidden">
  <div class="chat-header">
    <strong>¿En qué puedo ayudarte?</strong>
    <span class="close-chat" onclick="toggleChat()">&times;</span>
  </div>
  <div class="chat-body" id="chat-messages">
    <div class="bot-msg">¡Hola! ¿En qué puedo ayudarte hoy? 😊</div>
  </div>
  <div class="chat-input">
    <input type="text" id="user-input" placeholder="Escribe tu mensaje..." onkeydown="handleInput(event)">
  </div>
</div>
<script>
  function toggleChat() {
    var chatBox = document.getElementById('chat-box');
    chatBox.classList.toggle('hidden');
  }

  function handleInput(e) {
    if (e.key === 'Enter') {
      const input = document.getElementById('user-input');
      const msg = input.value.trim();
      if (msg !== '') {
        addMessage('user', msg);
        input.value = '';
        setTimeout(() => {
          addMessage('bot', generateResponse(msg));
        }, 600); // Simula un poco de "pensar"
      }
    }
  }

  function addMessage(sender, text) {
    const chat = document.getElementById('chat-messages');
    const msg = document.createElement('div');
    msg.className = sender === 'user' ? 'user-msg' : 'bot-msg';
    msg.innerText = text;
    chat.appendChild(msg);
    chat.scrollTop = chat.scrollHeight;
  }

  function generateResponse(input) {
    input = input.toLowerCase();
    if (input.includes('cursos') || input.includes('curso')) {
      return 'Ofrecemos cursos de programación, diseño y más. ¿Cuál te interesa?';
    } else if (input.includes('contacto') || input.includes('teléfono')) {
      return 'Puedes contactarnos al (+52) 844 256 7560 o al correo josiman280@gmail.com.';
    } else if (input.includes('gracias')) {
      return '¡De nada! 😊';
    } else {
      return 'Lo siento, soy un bot básico. Puedes dejar tu consulta y te contactaremos pronto.';
    }
  }
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Enviar mensaje por correo
  document.getElementById('formCorreo').addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('enviar_correo', '1'); // Bandera para el backend

    fetch('contact.php', {
      method: 'POST',
      body: formData
    })
    .then(resp => resp.json())
    .then(data => {
      alert(data.message);
      if (data.success) {
        document.getElementById('formCorreo').reset();
      }
    })
    .catch(err => {
      alert('❌ Error al enviar el mensaje.');
    });
  });

  // Registrar comentario
  document.getElementById('formComentario').addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('registrar', '1');

    fetch('contact.php', {
      method: 'POST',
      body: formData
    })
    .then(resp => resp.json())
    .then(data => {
      alert(data.message);
      if (data.success) {
        document.getElementById('formComentario').reset();
        location.reload(); // Opcional: recargar para ver el nuevo comentario
      }
    })
    .catch(err => {
      alert('❌ Error al registrar el comentario.');
    });
  });
});
</script>
</body>

</html>