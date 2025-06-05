<?php
require_once 'conexion.php';

try {
    $stmt = $pdo->query("SELECT * FROM Vista_Empleados_Detallada");
    $empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al consultar la vista: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Empleados</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap y MDB UI -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    body {
      background-color: #1e1e1e;
      color: white;
      font-family: 'Segoe UI', sans-serif;
      padding: 2rem 1rem 4rem;
    }

    h2 {
      font-size: 2.5rem;
      color: #ff8c00;
      text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.7);
      letter-spacing: 1.5px;
      text-align: center;
      margin-bottom: 2rem;
    }

    .table {
      background-color: #fff;
      border-radius: 12px;
      overflow: hidden;
    }

    .table thead {
      background-color: #343a40;
      color: #fff;
    }

    .table tbody tr:hover {
      background-color: #f1f1f1;
    }

    .btn-volver,
    .btn-nuevo {
      border: none;
      font-weight: 600;
      font-size: 1rem;
      padding: 0.6rem 1.5rem;
      border-radius: 10px;
      transition: all 0.2s ease-in-out;
    }

    .btn-volver {
      background-color: #ff8c00;
      color: white;
    }

    .btn-volver:hover {
      background-color: #e67600;
      transform: scale(1.05);
    }

    .btn-nuevo {
      background-color:rgb(217, 86, 9);
      color: white;
    }

    .btn-nuevo:hover {
      background-color: #2c5364;
      transform: scale(1.05);
    }

    .edit-icon {
      color: white;
      background-color: #0d6efd;
      border-radius: 6px;
      padding: 0.3rem 0.6rem;
      transition: background-color 0.2s;
    }

    .edit-icon:hover {
      background-color: #0b5ed7;
      color: white;
    }



    th, td {
      vertical-align: middle !important;
    }
  </style>
</head>
<body>

  <h2>Empleados Registrados</h2>

  <div class="container-fluid">
    <div class="table-container mb-4">
      <table class="table table-bordered table-hover text-dark">
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
            <th>RFC</th>
            <th>CURP</th>
            <th>NSS</th>
            <th>Usuario</th>
            <th>Puesto</th>
            <th>Editar</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($empleados as $emp): ?>
            <tr>
              <td><?= htmlspecialchars($emp['idEmpleado']) ?></td>
              <td><?= htmlspecialchars($emp['Nombre']) ?></td>
              <td><?= htmlspecialchars($emp['Paterno'] . ' ' . $emp['Materno']) ?></td>
              <td><?= htmlspecialchars($emp['Telefono']) ?></td>
              <td><?= htmlspecialchars($emp['Email']) ?></td>
              <td><?= htmlspecialchars($emp['Edad']) ?></td>
              <td><?= htmlspecialchars($emp['Sexo']) ?></td>
              <td><?= htmlspecialchars($emp['Calle']) ?></td>
              <td><?= htmlspecialchars($emp['Numero']) ?></td>
              <td><?= htmlspecialchars($emp['CodigoPostal']) ?></td>
              <td><?= htmlspecialchars($emp['Asentamiento']) ?></td>
              <td><?= htmlspecialchars($emp['TipoAsentamiento']) ?></td>
              <td><?= htmlspecialchars($emp['Zona']) ?></td>
              <td><?= htmlspecialchars($emp['Municipio']) ?></td>
              <td><?= htmlspecialchars($emp['Ciudad']) ?></td>
              <td><?= htmlspecialchars($emp['Estado']) ?></td>
              <td><?= htmlspecialchars($emp['Pais']) ?></td>
              <td><?= htmlspecialchars($emp['RFC']) ?></td>
              <td><?= htmlspecialchars($emp['CURP']) ?></td>
              <td><?= htmlspecialchars($emp['NumeroSeguroSocial']) ?></td>
              <td><?= htmlspecialchars($emp['Usuario']) ?></td>
              <td><?= htmlspecialchars($emp['Puesto']) ?></td>
              <td class="text-center">
                <a href="actualizar_empleado.php?id=<?= urlencode($emp['idEmpleado']) ?>" class="edit-icon" title="Editar">
                  <i class="bi bi-pencil-fill"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-start gap-3">
      <button class="btn-volver" onclick="window.location.href='pagina1.php'">Volver</button>
      <a href="AgregarEmpleado.php" class="btn-nuevo">Registrar Nuevo Empleado</a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
</body>
</html>
