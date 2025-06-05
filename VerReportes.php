<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Menú Principal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #2f2f2f;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      font-family: 'Segoe UI', sans-serif;
    }

    h1 {
      text-align: center;
      margin-top: 3rem;
      margin-bottom: 2rem;
      font-size: 2.5rem;
      color: #333;
      font-weight: 700;
    }

    .menu-container {
      max-width: 1000px;
      margin: 0 auto 3rem;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1.5rem;
    }

    .menu-item {
      background-color: white;
      border-radius: 1rem;
      padding: 2.8rem 1rem;
      font-size: 1.2rem;
      font-weight: 600;
      text-align: center;
      color: #333;
      text-decoration: none;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      transition: all 0.25s ease;
      user-select: none;
    }

    .menu-item:hover {
      background-color: #ff8c00;
      color: white;
      transform: translateY(-4px);
      box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
    }

    .btn-salir {
      position: fixed;
      top: 15px;
      right: 15px;
      background-color: #ff8c00;
      border: none;
      border-radius: 8px;
      padding: 0.5rem 1.2rem;
      font-size: 1rem;
      font-weight: 600;
      color: white;
      cursor: pointer;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
      transition: background 0.3s ease;
      z-index: 1000;
    }

    .btn-salir:hover {
      background-color: #e67600;
    }
  </style>
</head>
<body>

  <button class="btn-salir" onclick="window.location.href='pagina1.php'">Salir</button>
  <h1>Menú Reportes</h1>

  <div class="menu-container">
    <a href="VerCreditos.php" class="menu-item">Devoluciones</a>
    <a href="VerModificaciones.php" class="menu-item">Productos no aptos</a>
    <a href="TablaProductoProvedor.php" class="menu-item">Productos por Proveedor</a>
    <a href="VerEmpleados.php" class="menu-item">Productos Vendidos por Proveedor</a>
    <a href="VerEmpleados.php" class="menu-item">Empleados Antiguos</a>
    <a href="VerEmpleados.php" class="menu-item">Clientes Antiguos</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
