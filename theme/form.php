<?php
ob_start();
require_once 'db_conexion.php';
session_start();

$alertMessage = '';

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
          
            $_SESSION['curso'] = $userData['curso'];

            // Mostrar mensaje según el tipo de usuario
            if ($userData['usuario'] === 'admin') {
                $alertMessage = 'mostrarToast("Entrando como administrador", "success"); setTimeout(() => { window.location.href = "indexadmin.php"; }, 1500);';
            } else {
                $alertMessage = 'mostrarToast("Entrando como usuario", "success"); setTimeout(() => { window.location.href = "indexusuario.php"; }, 1500);';
            }
        } else {
            $alertMessage = 'mostrarToast("Credenciales incorrectas", "error");';
        }
    } else {
        $alertMessage = 'mostrarToast("Usuario o contraseña vacíos", "error");';
    }
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
    --><style>
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
                     <a href="index.html" class="top-right-btn btn btn-primary">Regresar al inicio</a>
                  </nav>
                        <!--Nav ul end-->
                     </div>
                     
                     <!-- Top bar btn -->
                  </nav>
                  <!-- Collapse end-->
      
     <section class="quote-area solid-bg" id="quote-area">
      <div class="container">
         <div class="row">
            <div class="col-lg-5">
               <div class="quote_form">
                  <h2 class="column-title "><span>¡Estamos felices de verte!</span>¡Bienvenido de nuevo!</h2>
                  <div class="quote-img">
                     <img class="img-fluid" src="images/curso.webp" alt="img">
                  </div>
               </div>
            </div>
            <div class="col-lg-7 qutoe-form-inner-le">
               <form class="contact-form" method="POST">
                  <h2 class="column-title "><span>¡Listo para sumergirte en tu cuenta. Inicia sesión ahora!</span>Inicio de Sesión</h2>
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="form-group">
                           <input class="form-control form-name" name="usuario" placeholder="Usuario o correo" type="text" required>
                        </div>
                     </div>
                     <div class="col-lg-12">
                        <div class="form-group">
                           <input class="form-control form-name" name="clave" placeholder="Clave" type="password" required>
                        </div>
                     </div>
                  </div>
                  <div class="text-right">
                     <button class="btn btn-primary tw-mt-30" type="submit" name="login">Iniciar Sesión</button>
                  </div>
                  <div class="mt-3">
                     <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
                     <a href="recuperar_clave.php">¿Olvidaste tu contraseña?</a>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </section>

   <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>

   <!-- Scripts -->
   <script src="js/jquery.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <script src="js/owl.carousel.min.js"></script>
   <script src="js/jquery.counterup.min.js"></script>
   <script src="js/waypoints.min.js"></script>
   <script src="js/jquery.colorbox.js"></script>
   <script src="js/custom.js"></script>

   <script>
   function mostrarToast(mensaje, tipo = 'error') {
      const container = document.getElementById('toast-container');
      const toast = document.createElement('div');
      toast.innerText = mensaje;
      toast.className = `toast ${tipo}`;
      toast.style = `
         background-color: ${tipo === 'error' ? '#dc3545' : '#28a745'};
         color: white;
         padding: 15px 20px;
         margin-bottom: 10px;
         border-radius: 4px;
         font-weight: bold;
         box-shadow: 0 0 10px rgba(0,0,0,0.2);
         animation: fadeIn 0.5s ease;
      `;
      container.appendChild(toast);
      setTimeout(() => {
         toast.style.animation = 'fadeOut 0.5s ease';
         toast.addEventListener('animationend', () => toast.remove());
      }, 3000);
   }

   // Ejecutar la alerta si existe mensaje desde PHP
   <?php if (!empty($alertMessage)): ?>
   window.addEventListener('DOMContentLoaded', () => {
      <?= $alertMessage ?>
   });
   <?php endif; ?>
   </script>

   <style>
   @keyframes fadeIn {
      from { opacity: 0; transform: translateX(100%); }
      to { opacity: 1; transform: translateX(0); }
   }
   @keyframes fadeOut {
      from { opacity: 1; transform: translateX(0); }
      to { opacity: 0; transform: translateX(100%); }
   }
   </style>
               </div>
                     </form>
                     <!-- Form end-->
                     
               </div>
               <!-- Col end-->
            </div>
            <!-- Content row end-->
         </div>
         <!-- Container end-->
      </section>
      <!-- Quote area end-->
                     </div>
                  </div>
               </div>
               <!-- Content row end-->
            </div>
            <!-- Container end-->
         </div>
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