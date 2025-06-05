<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Menú Principal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    body {
      background-color: #1e1e1e;
      font-family: 'Segoe UI', sans-serif;
      color: #fff;
      padding-top: 5rem;
    }

    h1 {
      text-align: center;
      font-weight: bold;
      font-size: 2.7rem;
      color: #ff8c00;
      margin-bottom: 3rem;
    }

    .menu-container {
      max-width: 1100px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 2rem;
      padding: 0 1rem 4rem;
    }

    .menu-card {
      background: #fff;
      color: #000;
      border: none;
      border-radius: 16px;
      padding: 2rem 1.2rem;
      text-align: center;
      text-decoration: none;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
      transition: all 0.25s ease-in-out;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .menu-card:hover {
      background-color: #ff8c00;
      color: #fff;
      transform: translateY(-6px);
      box-shadow: 0 8px 26px rgba(0, 0, 0, 0.3);
    }

    .menu-card i {
      font-size: 2.5rem;
      margin-bottom: 1rem;
      transition: color 0.3s ease;
    }

    .btn-salir {
      position: fixed;
      top: 15px;
      right: 15px;
      background-color: #ff8c00;
      border: none;
      border-radius: 8px;
      padding: 0.5rem 1.3rem;
      font-size: 1rem;
      font-weight: 600;
      color: white;
      cursor: pointer;
      box-shadow: 0 3px 8px rgba(0,0,0,0.4);
      transition: background-color 0.3s ease, transform 0.2s ease;
      z-index: 1000;
    }

    .btn-salir:hover {
      background-color: #e67600;
      transform: scale(1.05);
    }
  </style>
</head>
<body>

  <button class="btn-salir" onclick="window.location.href='Login.php'">Salir</button>

  <h1>Menú Principal</h1>

  <div class="menu-container">
    
    <a href="VerModificaciones.php" class="menu-card">
      <i class="bi bi-pencil-square"></i>
      Ver Modificaciones
    </a>
    
    <a href="VerEmpleados.php" class="menu-card">
      <i class="bi bi-people-fill"></i>
      Ver Empleados
    </a>
    <a href="VerClientes.php" class="menu-card">
      <i class="bi bi-person-check"></i>
      Ver Clientes
    </a>
    <a href="VerVentas.php" class="menu-card">
      <i class="bi bi-bar-chart-line-fill"></i>
      Ver Ventas
    </a>
    <a href="VerProveedores.php" class="menu-card">
      <i class="bi bi-truck"></i>
      Ver Proveedores
    </a>
  </div>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
</body>
</html>
