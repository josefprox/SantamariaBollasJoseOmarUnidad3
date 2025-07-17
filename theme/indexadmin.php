<?php
session_start();
require_once 'db_conexion.php';
require_once 'seguridad.php';
soloAdmin();

if (!isset($_SESSION['usuario'])) {
   header("Location: error_sesion.php");
   exit();
}

if (isset($_POST['cerrar_sesion'])) {
   session_destroy();
   header('Location: index.html');
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
require_once 'seguridad.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--
    Basic Page Needs
    ==================================================
    -->
    <meta charset="utf-8">
   <title>  Logicraft HTML5 Template</title>
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
   /* Efectos en los inputs */
.form-group input {
  transition: all 0.3s ease;
  border: 2px solid #ddd;
  border-radius: 8px;
  padding: 10px;
}

.form-group input:hover {
  border-color: #007bff;
  box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
}

.form-group input:focus {
  border-color: #007bff;
  outline: none;
  background-color: #f0f8ff;
}

/* Animación al cargar */
.contact-form {
  animation: fadeInUp 1s ease;
}

@keyframes fadeInUp {
  0% {
    opacity: 0;
    transform: translateY(30px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Botón con hover animado */
.btn-primary {
  transition: all 0.3s ease;
  transform: scale(1);
}

.btn-primary:hover {
  transform: scale(1.05);
  box-shadow: 0 10px 15px rgba(0, 0, 0, 0.15);
}
.card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border-radius: 15px;
}

.card:hover {
  transform: scale(1.05);
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
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
    $query = $cnnPDO->prepare('SELECT usuario, GROUP_CONCAT(curso) AS cursos FROM cursos GROUP BY usuario');
    $query->execute();

    echo '<div class="container">';
    echo '<div class="row justify-content-center mt-4 mb-4">';
    echo '<div class="col-md-12">';
    echo '<h2 class="text-center" style="font-size: 30px; margin-bottom: 30px; color:rgb(0, 0, 0);">Administración de cursos</h2>';

    // Formulario
    echo '<div class="col-lg-7 mx-auto mb-4">';
    echo '<form id="asignar-curso-form" name="gs" method="post" role="search" action="#">';
    echo '<div class="row justify-content-center align-items-center">';

    // Usuario select
    echo '<div class="col-lg-6">';
    echo '<select class="form-control mb-3" name="correo">';
    echo '<option selected>Selecciona un usuario</option>';
    $queryUsuarios = $cnnPDO->prepare('SELECT * FROM usuarios');
    $queryUsuarios->execute();
    while ($campo = $queryUsuarios->fetch()) {
        echo '<option>' . htmlspecialchars($campo['correo']) . '</option>';
    }
    echo '</select>';
    echo '</div>';

    // Curso select
    echo '<div class="col-lg-6">';
    echo '<select class="form-control mb-3" name="curso">';
    echo '<option selected>Selecciona un curso</option>';
    $queryCursos = $cnnPDO->prepare('SELECT DISTINCT curso FROM cursos');
    $queryCursos->execute();
    while ($campo = $queryCursos->fetch()) {
        echo '<option>' . htmlspecialchars($campo['curso']) . '</option>';
    }
    echo '</select>';
    echo '</div>';

    // Botón
    echo '<div class="col-lg-12 text-center">';
    echo '<button class="btn btn-danger px-4 py-2" type="button" id="btn-asignar">Asignar Curso</button>';
    echo '</div>';

    echo '</div>';
    echo '</form>';
    echo '</div>'; // Fin form
    echo '</div>'; // Fin col
    echo '</div>'; // Fin row formulario

    // Tarjetas de administración
    echo '<div class="row justify-content-center mt-4 mb-5">';
    while ($campo = $query->fetch()) {
        $usuario = $campo['usuario'];
        $cursos = explode(',', $campo['cursos']);

        echo '<div class="col-md-4 mb-4">';
        echo '<div class="card shadow-sm border-0 h-100" style="border-radius: 15px;">';
        echo '<div class="card-body d-flex flex-column align-items-center text-center">';

        // Ícono decorativo
        $icono = $usuario ? 'fa-user' : 'fa-book';
        $colorFondo = $usuario ? '#ffcdd2' : '#c8e6c9';
        $colorIcono = $usuario ? '#b71c1c' : '#2e7d32';
        echo '<div style="background-color: ' . $colorFondo . '; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">';
        echo '<i class="fa ' . $icono . '" style="font-size: 36px; color: ' . $colorIcono . ';"></i>';
        echo '</div>';

        // Título
        if ($usuario) {
            echo '<h5 class="card-title" style="font-size: 22px; font-weight: bold; color: #d32f2f;">' . htmlspecialchars($usuario) . '</h5>';
            echo '<p style="font-weight: 500; margin-top: 10px; color:rgb(0, 0, 0);" >Cursos asignados:</p>';
        } else {
            echo '<h5 class="card-title" style="font-size: 22px; font-weight: bold; color: #388e3c;">Cursos disponibles</h5>';
            echo '<p style="font-weight: 500; margin-top: 10px; color:rgb(27, 43, 28);">Para asignar a los usuarios:</p>';
        }

        // Lista de cursos
        echo '<ul class="list-unstyled" style="color: #555;">';
        foreach ($cursos as $curso) {
            echo '<li><i class="fa fa-check text-danger me-2"></i>' . htmlspecialchars(trim($curso)) . '</li>';
        }
        echo '</ul>';

        // Botón
        if ($usuario) {
            echo '<a href="#" class="btn mt-auto" style="background-color: #c62828; color: white; border-radius: 30px; padding: 8px 20px;">Ver más</a>';
        }

        echo '</div>'; // card-body
        echo '</div>'; // card
        echo '</div>'; // col
    }
    echo '</div>'; // row cards
    echo '</div>'; // container
}
?>
<section class="quote-area solid-bg" id="quote-area">
   <div class="container">
      <div class="row">
         <div class="col-lg-5">
            <div class="quote_form">
               <h2 class="column-title"><span>Nuevo curso</span>Agregar Curso</h2>
               <div class="quote-img">
                  <img class="img-fluid" src="images/cursos.png" alt="Agregar curso">
               </div>
            </div>
         </div>
         <div class="col-lg-7 qutoe-form-inner-le">
            <form class="contact-form" method="POST" action="">
               <h2 class="column-title"><span>Completa la información</span>Crear nuevo curso</h2>
               <div class="row">
                  <div class="col-lg-12">
                     <div class="form-group">
                        <input class="form-control" name="curso" placeholder="Nombre del curso" type="text" required>
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <div class="form-group">
                        <input class="form-control" name="duracion" placeholder="Duración (ej. 3 meses)" type="text" required>
                     </div>
                  </div>
               </div>
               <div class="text-right">
                  <button class="btn btn-primary tw-mt-30" type="submit">Agregar Curso</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</section>
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
  <script>
$(document).ready(function () {
    $('#btn-asignar').on('click', function () {
        const form = $('#asignar-curso-form');
        const formData = form.serialize();

        $.ajax({
            url: 'asignar_curso.php', // asegúrate de que esta ruta sea correcta
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'ok') {
                    alert(response.message);
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                alert('Error en la solicitud AJAX.');
                console.log('Status:', status);
                console.log('XHR:', xhr.responseText);
                console.log('Error:', error);
            }
        });
    });
});
</script>
<script>
// Efecto al enfocar campos
const inputs = document.querySelectorAll('.form-control');

inputs.forEach(input => {
  input.addEventListener('focus', () => {
    input.style.backgroundColor = '#f8f9fa';
  });

  input.addEventListener('blur', () => {
    input.style.backgroundColor = '';
  });
});
</script>
</body>

</html>