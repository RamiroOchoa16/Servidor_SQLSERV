<?php
require_once 'conexion.php';

try {
    $stmt = $pdo->query("SELECT * FROM vw_HistorialModificaciones");
    $modificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al consultar la vista: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Historial de Modificaciones</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f2f2f2;
      font-family: sans-serif;
    }

    .container-custom {
      max-width: 1200px;
      margin: 50px auto;
      background-color: white;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
      font-weight: bold;
    }

    .table th,
    .table td {
      vertical-align: middle;
      font-size: 0.95rem;
    }

    .table thead th {
      background-color: #ff8c00;
      color: white;
    }

    .btn-orange {
      background-color: #ff8c00;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      transition: background-color 0.3s;
    }

    .btn-orange:hover {
      background-color: #e67600;
    }

    .btn-dark-style {
      background-color: #333;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      transition: background-color 0.3s;
    }

    .btn-dark-style:hover {
      background-color: #111;
    }

    .button-group {
      display: flex;
      gap: 1rem;
      margin-top: 30px;
    }
  </style>
</head>
<body>

<div class="container container-custom">
  <h2>Historial de Modificaciones</h2>

  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Movimiento</th>
          <th>Tabla Afectada</th>
          <th>Columna Afectada</th>
          <th>Valor Anterior</th>
          <th>Valor Nuevo</th>
          <th>Fecha</th>
          <th>Hora</th>
          <th>ID Empleado</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($modificaciones as $mod): ?>
          <tr>
            <td><?= htmlspecialchars($mod['ID']) ?></td>
            <td><?= htmlspecialchars($mod['Movimiento']) ?></td>
            <td><?= htmlspecialchars($mod['TablaAfectada']) ?></td>
            <td><?= htmlspecialchars($mod['ColumnaAfectada']) ?></td>
            <td><?= htmlspecialchars($mod['ValorAnterior']) ?></td>
            <td><?= htmlspecialchars($mod['ValorNuevo']) ?></td>
            <td><?= htmlspecialchars($mod['Fecha']) ?></td>
            <td><?= htmlspecialchars($mod['Hora']) ?></td>
            <td><?= htmlspecialchars($mod['idEmpleado']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="button-group mt-4">
    <button type="button" class="btn-dark-style" onclick="window.location.href='pagina1.php'">
      Volver
    </button>

    <form action="generar_historial_pdf.php" method="post">
      <button type="submit" class="btn-orange">
        Descargar PDF
      </button>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
