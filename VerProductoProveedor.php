<?php
require_once 'conexion.php';

$proveedores = [];
$productos = [];
$mensaje = "";
$mensajeTipo = "";

try {
    // Cargar proveedores para el select
    $stmtProv = $pdo->query("SELECT idProveedor, Nombre FROM Vista_Todos_Proveedores ORDER BY Nombre");
    $proveedores = $stmtProv->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idProveedor'])) {
        $idProveedor = intval($_POST['idProveedor']);
        if ($idProveedor > 0) {
            // Llamar al procedimiento almacenado para obtener productos del proveedor seleccionado
            $stmtProd = $pdo->prepare("EXEC ObtenerProductosPorProveedor @p_idProveedor = :idProveedor");
            $stmtProd->bindParam(':idProveedor', $idProveedor, PDO::PARAM_INT);
            $stmtProd->execute();
            $productos = $stmtProd->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $mensaje = "Selecciona un proveedor válido.";
            $mensajeTipo = "warning";
        }
    }
} catch (PDOException $e) {
    $mensaje = "Error de base de datos: " . $e->getMessage();
    $mensajeTipo = "danger";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Productos por Proveedor</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />

  <style>
    body {
      background-color: #2f2f2f;
      font-family: 'Segoe UI', sans-serif;
      color: #fff;
    }

    .container-box {
      background-color: #fff;
      color: #000;
      border-radius: 1rem;
      padding: 2rem;
      margin-top: 3rem;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
    }

    .title {
      color: #ff8c00;
      font-weight: bold;
      text-align: center;
      margin-bottom: 2rem;
    }

    .btn-orange {
      background-color: #ff8c00;
      color: white;
    }

    .btn-orange:hover {
      background-color: #e67600;
    }

    .table thead {
      background-color: #343a40;
      color: #fff;
    }

    .alert {
      font-size: 0.95rem;
    }

    select.form-select {
      border-radius: 0.5rem;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="container-box">
    <h2 class="title">Productos por Proveedor</h2>

    <?php if ($mensaje): ?>
      <div class="alert alert-<?php echo htmlspecialchars($mensajeTipo); ?>" role="alert">
        <?php echo htmlspecialchars($mensaje); ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="mb-4">
      <label for="idProveedor" class="form-label">Selecciona un Proveedor:</label>
      <select name="idProveedor" id="idProveedor" class="form-select" required>
        <option value="">-- Seleccionar proveedor --</option>
        <?php foreach ($proveedores as $prov): ?>
          <option value="<?= htmlspecialchars($prov['idProveedor']) ?>"
            <?= (isset($idProveedor) && $idProveedor == $prov['idProveedor']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($prov['Nombre']) ?>
          </option>
        <?php endforeach; ?>
    </select>
        <div class="d-flex gap-2 mt-3">
        
            <a href="pagina1.php" class="btn btn-secondary">Salir</a>
    </div>

    </form>

    <?php if (!empty($productos)): ?>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>ID Producto</th>
              <th>Nombre</th>
              <th>Precio Compra</th>
              <th>Precio Venta</th>
              <th>Stock</th>
              <th>Estado</th>
              <th>ID Categoría</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($productos as $prod): ?>
              <tr>
                <td><?= htmlspecialchars($prod['idProducto']) ?></td>
                <td><?= htmlspecialchars($prod['Nombre']) ?></td>
                <td>$<?= number_format($prod['PrecioCompra'], 2) ?></td>
                <td>$<?= number_format($prod['PrecioVenta'], 2) ?></td>
                <td><?= htmlspecialchars($prod['Stock']) ?></td>
                <td><?= htmlspecialchars($prod['Estado']) ?></td>
                <td><?= htmlspecialchars($prod['idCategoria']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php elseif (isset($idProveedor)): ?>
      <div class="alert alert-info">No se encontraron productos para este proveedor.</div>
    <?php endif; ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
</body>
</html>
