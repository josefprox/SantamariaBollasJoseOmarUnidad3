<?php
session_start();
require_once 'db_conexion.php';
require_once 'seguridad.php';
soloUsuario();

if (!isset($_SESSION['usuario'])) {
   header("Location: error_sesion.php");
   exit();
}

if (isset($_POST['cerrar_sesion'])) {
    session_destroy();
    header("Location: index.html");
    exit();
}
if (isset($_POST['correo']) && isset($_POST['curso'])) {
   $correo = trim($_POST['correo']);
   $curso = trim($_POST['curso']);

   if (!empty($correo) && !empty($curso)) {
      $query = $cnnPDO->prepare('INSERT INTO cursos (usuario, curso) VALUES (?, ?)');
      $query->execute([$correo, $curso]);
      header("Location: " . $_SERVER['PHP_SELF']);
      exit();
   }
}
if (isset($_POST['curso']) && isset($_POST['duracion'])) {
   $curso = trim($_POST['curso']);
   $duracion = trim($_POST['duracion']);

   if (!empty($curso) && !empty($duracion)) {
      $query = $cnnPDO->prepare('INSERT INTO cursos (curso, duracion) VALUES (?, ?)');
      $query->execute([$curso, $duracion]);

      // Redirige para evitar reenvío del formulario
      header("Location: " . $_SERVER['PHP_SELF']);
      exit();
        }
}
?>

 <script>
        var inactivityTimeout;

        function resetTimer() {
            clearTimeout(inactivityTimeout);
            inactivityTimeout = setTimeout(logout, 35000); 
        }

        function logout() {
            window.location.href = 'form.php'; 
        }

        document.addEventListener('mousemove', resetTimer);
        document.addEventListener('keydown', resetTimer);
    </script>   
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
        <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
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

    <head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lenguajes y Herramientas</title>
  <style>
    .ts-service-image-wrapper {
       width: 100%;
       height: 200px; /* altura fija para todas las imágenes */
       display: flex;
       justify-content: center;
       align-items: center;
       overflow: hidden;
       background-color: #f5f5f5;
       border-radius: 8px;
    }

    .ts-service-image-wrapper img {
       width: 100%;
       height: 100%;
       object-fit: cover; /* ajusta la imagen sin deformar */
       display: block;
    }

    /* Opcional: algo de estilo para el contenedor y textos */
    .ts-service-box {
      box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
      border-radius: 8px;
      overflow: hidden;
      background-color: white;
      margin-bottom: 24px;
    }

    .ts-service-content {
      padding: 15px;
    }

    .service-title {
      margin-top: 10px;
      font-size: 1.3rem;
      font-weight: 600;
    }

    .link-more {
      text-decoration: none;
      color: #007bff;
      font-weight: 500;
    }

    .link-more:hover {
      text-decoration: underline;
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
  .card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border-radius: 15px;
}

.card:hover {
  transform: scale(1.05);
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
}
    .ts-service-box {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.ts-service-box:hover {
  transform: scale(1.05); /* Zoom */
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); /* Sombra más pronunciada */
}
.ts-service-image-wrapper {
  overflow: hidden;
}

.ts-service-image-wrapper img {
  transition: transform 0.3s ease;
}

.ts-service-box:hover .ts-service-image-wrapper img {
  transform: scale(0.9);
}
.card {
  background-color:rgb(238, 112, 112);
  background-image: linear-gradient(43deg,rgb(235, 74, 74) 0%,rgb(252, 252, 252) 46%,rgb(156, 16, 16) 100%);
  border-radius: 8px;
  color: white;
  overflow: hidden;
  position: relative;
  transform-style: preserve-3d;
  perspective: 1000px;
  transition: all 0.5s cubic-bezier(0.23, 1, 0.320, 1);
  cursor: pointer;
}

.card-content {
  padding: 20px;
  position: relative;
  z-index: 1;
  display: flex;
  flex-direction: column;
  gap: 10px;
  color: white;
  align-items: center;
  justify-content: center;
  text-align: center;
  height: 100%;
}

.card-content .card-title {
  font-size: 24px;
  font-weight: 700;
  color: inherit;
  text-transform: uppercase;
}

.card-content .card-para {
  color: inherit;
  opacity: 0.8;
  font-size: 14px;
}

.card:hover {
  transform: rotateY(10deg) rotateX(10deg) scale(1.05);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.card:before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(transparent, rgba(0, 0, 0, 0.1));
  transition: transform 0.5s cubic-bezier(0.23, 1, 0.320, 1);
  z-index: 1;
}

.card:hover:before {
  transform: translateX(-100%);
}

.card:after {
  content: "";
  position: absolute;
  top: 0;
  right: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(transparent, rgba(0, 0, 0, 0.1));
  transition: transform 0.5s cubic-bezier(0.23, 1, 0.320, 1);
  z-index: 1;
}

.card:hover:after {
  transform: translateX(100%);
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
                                 <p class="info-title">Correo:</p>
                                 <p class="info-subtitle"><?php echo $_SESSION['correo'];?></p>
                              </div>
                           </li>
                           <li><span class="info-icon"><i class="icon icon-envelope"></i></span>
                              <div class="info-wrapper">
                                 <p class="info-title">Usuario:</p>
                                 <p class="info-subtitle"><?php echo $_SESSION['usuario'];?></p>
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
               
                     </div>
                     <form method="post" class="form-inline">
                <button type="submit" name="cerrar_sesion" class="top-right-btn btn btn-primary">
                    Cerrar sesion
                </button>
            </form>
                     <!-- Top bar btn -->
                  </nav>
                  <!-- Collapse end-->

                  
                  
               </div>
            </div>
            <!-- Site nav inner end-->
         </header>
         <!-- Header end-->
      </div>

  <?php
if (isset($_SESSION['usuario'])) {
    $query = $cnnPDO->prepare('SELECT * FROM cursos WHERE usuario = :usuario');
    $query->bindParam(':usuario', $_SESSION['correo']);
    $query->execute();

    echo '<div class="row justify-content-center mt-4 mb-4">';
    echo '<div class="col-md-12">';
    echo '<h2 class="text-center" style="font-size: 30px; margin-bottom: 30px; color:rgb(0, 0, 0);">Mis Cursos</h2>';
    echo '</div>';

    while ($campo = $query->fetch()) {
        echo '<div class="col-md-4 mb-4">';
        echo '  <div class="card shadow-sm border-0 h-100" style="border-radius: 15px;">';
        echo '    <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">';
        echo '      <div style="background-color: #ffcdd2; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">';
        echo '        <i class="fa fa-book" style="font-size: 36px; color: #b71c1c;"></i>';
        echo '      </div>';
        echo '      <h5 class="card-title" style="font-size: 22px; font-weight: bold; color: #d32f2f;">' . htmlspecialchars($campo['curso']) . '</h5>';
        echo '      <p class="card-text" style="color: #555;">Usuario: <strong>' . htmlspecialchars($_SESSION['usuario']) . '</strong></p>';
        echo '      <a href="#" class="btn mt-auto" style="background-color: #c62828; color: white; border-radius: 30px; padding: 8px 20px;">Leer más</a>';
        echo '    </div>';
        echo '  </div>';
        echo '</div>';
    }

    echo '</div>';

    echo '<div class="row justify-content-center mt-5 mb-4">';
    echo '<div class="col-md-12">';
    echo '<h2 class="text-center" style="font-size: 30px; margin-bottom: 20px; color:rgb(0, 0, 0);">Más Cursos</h2>';
    echo '</div>';
    echo '</div>';
}
?>
<section class="main-container no-padding" id="main-container">
   <div class="ts-services" id="ts-services">
      <div class="container">
         <div class="row text-center">
            <div class="col-md-12">
               <h2 class="section-title"><span>Explora contenidos de programación</span>Lenguajes y Herramientas</h2>
               <p class="mt-2">Buscar curso:</p>
               <input type="text" id="buscador" class="form-control mt-1" placeholder="Buscar lenguaje o herramienta...">
            </div>
         </div>
         <br>
         <div class="row" id="cards-container">
            <div class="col-lg-4 col-md-12 card-item" data-aos="fade-up">
               <div class="ts-service-box">
                  <div class="ts-service-image-wrapper">
                     <img class="img-fluid" src="images/services/serv1.jpg" alt="Python">
                  </div>
                  <div class="ts-service-content">
                     <h3 class="service-title">Python</h3>
                     <p>Lenguaje versátil usado en ciencia de datos, backend y automatización.</p>
                     <p><a class="link-more" href="form.php">Inicia sesión <i class="icon icon-right-arrow2"></i></a></p>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-12 card-item" data-aos="fade-up">
               <div class="ts-service-box">
                  <div class="ts-service-image-wrapper">
                     <img class="img-fluid" src="images/services/serv2.jpg" alt="Java">
                  </div>
                  <div class="ts-service-content">
                     <h3 class="service-title">Java</h3>
                     <p>Popular en desarrollo empresarial, Android y sistemas robustos.</p>
                     <p><a class="link-more" href="form.php">Inicia sesión <i class="icon icon-right-arrow2"></i></a></p>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-12 card-item" data-aos="fade-up">
               <div class="ts-service-box">
                  <div class="ts-service-image-wrapper">
                     <img class="img-fluid" src="images/services/serv3.jpg" alt="JavaScript">
                  </div>
                  <div class="ts-service-content">
                     <h3 class="service-title">JavaScript</h3>
                     <p>Lenguaje clave para el desarrollo web interactivo en el navegador.</p>
                     <p><a class="link-more" href="form.php">Inicia sesión <i class="icon icon-right-arrow2"></i></a></p>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-12 card-item" data-aos="fade-up">
               <div class="ts-service-box">
                  <div class="ts-service-image-wrapper">
                     <img class="img-fluid" src="images/services/serv4.png" alt="MySQL">
                  </div>
                  <div class="ts-service-content">
                     <h3 class="service-title">MySQL</h3>
                     <p>Sistema de gestión de bases de datos relacional ampliamente usado.</p>
                     <p><a class="link-more" href="form.php">Inicia sesión <i class="icon icon-right-arrow2"></i></a></p>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-12 card-item" data-aos="fade-up">
               <div class="ts-service-box">
                  <div class="ts-service-image-wrapper">
                     <img class="img-fluid" src="images/services/serv5.png" alt="PHP">
                  </div>
                  <div class="ts-service-content">
                     <h3 class="service-title">PHP</h3>
                     <p>Lenguaje de scripting usado en servidores para construir sitios web dinámicos.</p>
                     <p><a class="link-more" href="form.php">Inicia sesión <i class="icon icon-right-arrow2"></i></a></p>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-12 card-item" data-aos="fade-up">
               <div class="ts-service-box">
                  <div class="ts-service-image-wrapper">
                     <img class="img-fluid" src="images/services/serv6.svg" alt="Node.js">
                  </div>
                  <div class="ts-service-content">
                     <h3 class="service-title">Node.js</h3>
                     <p>Entorno para ejecutar JavaScript del lado del servidor, ideal para apps en tiempo real.</p>
                     <p><a class="link-more" href="form.php">Inicia sesión <i class="icon icon-right-arrow2"></i></a></p>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-12 card-item" data-aos="fade-up">
               <div class="ts-service-box">
                  <div class="ts-service-image-wrapper">
                     <img class="img-fluid" src="images/services/serv7.jpg" alt="SQL Server">
                  </div>
                  <div class="ts-service-content">
                     <h3 class="service-title">SQL Server</h3>
                     <p>Base de datos relacional de Microsoft para soluciones empresariales.</p>
                     <p><a class="link-more" href="form.php">Inicia sesión <i class="icon icon-right-arrow2"></i></a></p>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-12 card-item" data-aos="fade-up">
               <div class="ts-service-box">
                  <div class="ts-service-image-wrapper">
                     <img class="img-fluid" src="images/services/serv8.png" alt="C#">
                  </div>
                  <div class="ts-service-content">
                     <h3 class="service-title">C#</h3>
                     <p>Lenguaje moderno desarrollado por Microsoft para aplicaciones web, móviles y juegos.</p>
                     <p><a class="link-more" href="form.php">Inicia sesión <i class="icon icon-right-arrow2"></i></a></p>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-12 card-item" data-aos="fade-up">
               <div class="ts-service-box">
                  <div class="ts-service-image-wrapper">
                     <img class="img-fluid" src="images/services/serv9.png" alt="Laravel">
                  </div>
                  <div class="ts-service-content">
                     <h3 class="service-title">Laravel</h3>
                     <p>Framework de PHP elegante y potente para desarrollar aplicaciones web robustas.</p>
                     <p><a class="link-more" href="form.php">Inicia sesión <i class="icon icon-right-arrow2"></i></a></p>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-12 card-item" data-aos="fade-up">
               <div class="ts-service-box">
                  <div class="ts-service-image-wrapper">
                     <img class="img-fluid" src="images/services/serv10.png" alt="React">
                  </div>
                  <div class="ts-service-content">
                     <h3 class="service-title">React</h3>
                     <p>Biblioteca de JavaScript para construir interfaces de usuario reactivas y modernas.</p>
                     <p><a class="link-more" href="form.php">Inicia sesión <i class="icon icon-right-arrow2"></i></a></p>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-12 card-item" data-aos="fade-up">
               <div class="ts-service-box">
                  <div class="ts-service-image-wrapper">
                     <img class="img-fluid" src="images/services/serv11.png" alt="MongoDB">
                  </div>
                  <div class="ts-service-content">
                     <h3 class="service-title">MongoDB</h3>
                     <p>Base de datos NoSQL orientada a documentos, ideal para datos flexibles y escalables.</p>
                     <p><a class="link-more" href="form.php">Inicia sesión <i class="icon icon-right-arrow2"></i></a></p>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-12 card-item" data-aos="fade-up">
               <div class="ts-service-box">
                  <div class="ts-service-image-wrapper">
                     <img class="img-fluid" src="images/services/serv12.jpg" alt="Python IA">
                  </div>
                  <div class="ts-service-content">
                     <h3 class="service-title">Python para IA</h3>
                     <p>Uso de Python con librerías como TensorFlow y PyTorch en inteligencia artificial.</p>
                     <p><a class="link-more" href="form.php">Inicia sesión <i class="icon icon-right-arrow2"></i></a></p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<style>
  #buscador {
    font-size: 1.2rem;
    padding: 12px 15px;
    border: 2px solid #d32f2f; /* rojo fuerte */
    border-radius: 8px;
    box-shadow: 0 0 8px rgba(211, 47, 47, 0.6); /* sombra roja */
    background-color: #fdecea; /* fondo rojo muy suave */
    transition: border-color 0.3s, box-shadow 0.3s;
  }

  #buscador:focus {
    outline: none;
    border-color: #9a0000; /* rojo más oscuro */
    box-shadow: 0 0 12px rgba(154, 0, 0, 0.8);
    background-color: #ffffff;
  }
</style>

         <!-- Footer Main-->
         <div class="copyright">
            <div class="container">
               <div class="row">
                  <div class="col-lg-6 col-md-12">
                     <div class="copyright-info"><span>Copyright © 2025 a theme by <a>Cursos Data</a></span></div>
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
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 800,
    once: true
  });
</script>
</body>

</html>