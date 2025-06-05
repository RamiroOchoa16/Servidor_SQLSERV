<?php
require_once 'conexion.php';

try {
    $stmt = $pdo->query("SELECT * FROM Vista_Todos_Proveedores");
    $proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al consultar la vista: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Proveedores</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />

  <style>
    body {
      background-color: #2f2f2f;
      font-family: 'Segoe UI', sans-serif;
      color: #fff;
    }

    .table-container {
      background-color: #fff;
      border-radius: 1rem;
      padding: 2rem;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
    }

    .table thead {
      background-color: #343a40;
      color: #fff;
    }

    .table tbody tr:hover {
      background-color: #f2f2f2;
    }

    .btn-orange {
      background-color: #ff8c00;
      color: white;
    }

    .btn-orange:hover {
      background-color: #e67600;
    }

    .btn-darkish {
      background-color: #444;
      color: white;
    }

    .btn-darkish:hover {
      background-color: #333;
    }

    h2.title {
      color: #ff8c00;
      font-weight: bold;
      margin-bottom: 2rem;
      text-align: center;
    }

    .icon-eye {
      font-size: 1.5rem;
      text-decoration: none;
      color: #ff8c00;
      transition: color 0.3s ease;
    }

    .icon-eye:hover {
      color: #e67600;
    }

    .table th, .table td {
      font-size: 0.95rem;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <h2 class="title">Proveedores Registrados</h2>

  <div class="table-container table-responsive">
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Ver</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($proveedores as $prov): ?>
          <tr>
            <td><?= htmlspecialchars($prov['idProveedor']) ?></td>
            <td><?= htmlspecialchars($prov['Nombre']) ?></td>
            <td class="text-center">
              <a href="VerProductoProveedor.php?id=<?= urlencode($prov['idProveedor']) ?>" class="icon-eye" title="Ver proveedor">👁</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="d-flex justify-content-start gap-3 mt-4">
    <a href="pagina1.php" class="btn btn-secondary">Salir</a>
    <a href="AgregarProvedor.php" class="btn btn-orange">Registrar Nuevo Proveedor</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
</body>
</html>
