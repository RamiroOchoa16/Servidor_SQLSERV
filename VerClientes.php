<?php
require_once 'conexion.php';

try {
    $stmt = $pdo->query("SELECT * FROM vw_ClientesActivos");
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al consultar la vista: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Clientes Activos</title>
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

    .table th, .table td {
      font-size: 0.875rem;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <h2 class="title">Clientes Activos Registrados</h2>

  <div class="table-container table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Teléfono</th>
        <th>Email</th>
        <th>Edad</th>
        <th>Sexo</th>
        <th>Calle</th>
        <th>Número</th>
        <th>Código Postal</th>
        <th>Asentamiento</th>
        <th>Tipo</th>
        <th>Zona</th>
        <th>Municipio</th>
        <th>Ciudad</th>
        <th>Estado</th>
        <th>País</th>
        <th>Crédito</th>
        <th>Límite</th>
        <th>Descuento</th>
        <th>Acciones</th> <!-- NUEVA COLUMNA -->
      </tr>
    </thead>
    <tbody>
      <?php foreach ($clientes as $cli): ?>
        <tr>
          <td><?= htmlspecialchars($cli['idCliente']) ?></td>
          <td><?= htmlspecialchars($cli['Nombre']) ?></td>
          <td><?= htmlspecialchars($cli['Paterno'] . ' ' . $cli['Materno']) ?></td>
          <td><?= htmlspecialchars($cli['Telefono']) ?></td>
          <td><?= htmlspecialchars($cli['Email']) ?></td>
          <td><?= htmlspecialchars($cli['Edad']) ?></td>
          <td><?= htmlspecialchars($cli['Sexo']) ?></td>
          <td><?= htmlspecialchars($cli['Calle']) ?></td>
          <td><?= htmlspecialchars($cli['Numero']) ?></td>
          <td><?= htmlspecialchars($cli['CodigoPostal']) ?></td>
          <td><?= htmlspecialchars($cli['Asentamiento']) ?></td>
          <td><?= htmlspecialchars($cli['TipoAsentamiento']) ?></td>
          <td><?= htmlspecialchars($cli['Zona']) ?></td>
          <td><?= htmlspecialchars($cli['Municipio']) ?></td>
          <td><?= htmlspecialchars($cli['Ciudad']) ?></td>
          <td><?= htmlspecialchars($cli['Estado']) ?></td>
          <td><?= htmlspecialchars($cli['Pais']) ?></td>
          <td><?= htmlspecialchars($cli['Credito']) ?></td>
          <td><?= htmlspecialchars($cli['Limite']) ?></td>
          <td><?= htmlspecialchars($cli['Descuento']) ?></td>
          <td>
            <a href="actualizar_cliente.php?id=<?= $cli['idCliente'] ?>" class="btn btn-sm btn-warning">Editar</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

  <div class="d-flex justify-content-start gap-3 mt-4">
    <a href="pagina1.php" class="btn btn-secondary">Salir</a>
    <a href="AgregarCliente.php" class="btn btn-orange">Registrar Nuevo Cliente</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
</body>
</html>
        