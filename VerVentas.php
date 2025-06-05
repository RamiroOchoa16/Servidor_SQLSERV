<?php
session_start();
require_once 'conexion.php';

$fechaSeleccionada = date('Y-m-d');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["fecha"])) {
        $fechaSeleccionada = $_POST["fecha"];
    }

    if (isset($_POST["accion"])) {
        $accion = $_POST["accion"];
        if ($accion === "descargar") {
            header("Location: TicketVentasDiarias.php?fecha=" . urlencode($fechaSeleccionada));
            exit;
        }
    }
}

$ventas = [];
$sql = "SELECT * FROM VistaVentasDiarias WHERE CAST(Fecha AS DATE) = ?";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(1, $fechaSeleccionada);
$stmt->execute();
$ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resumen de Ventas del Día</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f5f5f5;
      font-family: sans-serif;
    }

    .container-custom {
      max-width: 1200px;
      margin: 50px auto;
      background-color: white;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    h1, h2 {
      color: #333;
      font-weight: bold;
      text-align: center;
    }

    .formulario {
      background-color: #f8f8f8;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 30px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
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

    .btn-gray {
      background-color: #333;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      transition: background-color 0.3s;
    }

    .btn-gray:hover {
      background-color: #111;
    }

    .table thead th {
      background-color: #ff8c00;
      color: white;
      text-align: center;
    }

    .table td, .table th {
      vertical-align: middle;
    }

    .alert-warning {
      font-weight: bold;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="container container-custom">
  <h1 class="mb-4">Ventas del Día</h1>

  <div class="formulario">
    <form method="POST" action="" class="row g-3 align-items-end">
      <div class="col-md-4">
        <label for="fecha" class="form-label">Seleccionar fecha:</label>
        <input type="date" name="fecha" id="fecha" class="form-control" required value="<?= htmlspecialchars($fechaSeleccionada); ?>">
      </div>
      <div class="col-md-8 d-flex gap-2">
        <button type="submit" name="accion" value="buscar" class="btn btn-gray">Buscar</button>
        <button type="submit" name="accion" value="descargar" class="btn btn-orange">Descargar</button>
      </div>
    </form>
  </div>

  <?php if (empty($ventas)): ?>
    <div class="alert alert-warning">No hay ventas registradas en esta fecha.</div>
  <?php else: ?>
    <?php 
      $ventasPorEmpleado = [];
      foreach ($ventas as $venta) {
          $ventasPorEmpleado[$venta['Empleado']][] = $venta;
      }

      foreach ($ventasPorEmpleado as $empleado => $ventasEmpleado): 
    ?>
      <h2 class="mb-3">Ventas de <?= htmlspecialchars($empleado); ?></h2>
      <div class="table-responsive mb-5">
        <table class="table table-bordered table-hover bg-white">
          <thead>
            <tr>
              <th>Número de Venta</th>
              <th>Cliente</th>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Precio</th>
              <th>Subtotal</th>
              <th>Hora</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $sumaTotalEmpleado = 0;
            foreach ($ventasEmpleado as $venta): 
                $sumaTotalEmpleado += $venta['Subtotal'];
            ?>
            <tr>
              <td><?= $venta['NumeroVenta']; ?></td>
              <td><?= $venta['Cliente']; ?></td>
              <td><?= $venta['Producto']; ?></td>
              <td><?= number_format($venta['Cantidad'], 2); ?></td>
              <td><?= '$' . number_format($venta['PrecioUnitario'], 2); ?></td>
              <td><?= '$' . number_format($venta['Subtotal'], 2); ?></td>
              <td><?= $venta['Hora']; ?></td>
            </tr>
            <?php endforeach; ?>
            <tr class="table-secondary">
              <td colspan="5" class="text-end"><strong>Total del día:</strong></td>
              <td colspan="2"><strong><?= '$' . number_format($sumaTotalEmpleado, 2); ?></strong></td>
            </tr>
          </tbody>
        </table>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
