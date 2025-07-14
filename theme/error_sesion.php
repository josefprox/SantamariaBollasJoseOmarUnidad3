<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Sesión expirada</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,700&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #ffebee;
      color: #b71c1c;
      font-family: 'Fira Sans', sans-serif;
      text-align: center;
      padding: 100px 20px;
      overflow-x: hidden;
      animation: fadeInBody 1s ease;
    }

    @keyframes fadeInBody {
      from { opacity: 0; transform: translateY(30px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .error-container {
      max-width: 600px;
      margin: auto;
      background: white;
      border: 2px solid #ef9a9a;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
      animation: fadeInCard 1.2s ease;
    }

    @keyframes fadeInCard {
      from { opacity: 0; transform: scale(0.95); }
      to   { opacity: 1; transform: scale(1); }
    }

    h1 {
      font-size: 48px;
      margin-bottom: 20px;
      color: #d32f2f;
      animation: fadeInDown 1.3s ease;
    }

    @keyframes fadeInDown {
      from { opacity: 0; transform: translateY(-20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    p {
      font-size: 18px;
      margin-bottom: 30px;
      animation: fadeInUp 1.5s ease;
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    a.btn {
      background-color: #c62828;
      color: white;
      padding: 12px 28px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      font-size: 16px;
      transition: transform 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;
    }

    a.btn:hover {
      background-color: #b71c1c;
      transform: translateY(-3px);
      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>
<body>
  <div class="error-container">
    <h1>¡Sesión finalizada!</h1>
    <p>Tu sesión ha expirado o no tienes permiso para acceder a esta página.</p>
    <a href="index.html" class="btn">Volver al inicio</a>
  </div>
</body>
</html>