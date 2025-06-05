<?php
require_once 'conexion.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$mensaje = "";
$mensajeTipo = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $nombreProveedor = trim($_POST["Nombre"]);

        if (empty($nombreProveedor)) {
            throw new Exception("El nombre del proveedor está vacío.");
        }

        $stmt = $pdo->prepare("EXEC AgregarProveedor @p_nombre = :nombre");
        $stmt->bindParam(':nombre', $nombreProveedor, PDO::PARAM_STR);
        $stmt->execute();

        $mensaje = "Proveedor registrado con éxito.";
        $mensajeTipo = "success";
    } catch (PDOException $e) {
        $mensaje = "Error de base de datos: " . $e->getMessage();
        $mensajeTipo = "danger";
    } catch (Exception $e) {
        $mensaje = "Error: " . $e->getMessage();
        $mensajeTipo = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Registro de Proveedor</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />

  <style>
    body {
      background-color: #2f2f2f;
      font-family: 'Segoe UI', sans-serif;
    }

    .form-container {
      background-color: #ffffff;
      border-radius: 1rem;
      padding: 3rem;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
      margin-top: 3rem;
      margin-bottom: 3rem;
    }

    .form-control {
      background-color: #f7f7f7;
      border: 1px solid #ccc;
      color: #333;
    }

    .form-control:focus {
      border-color: #ff8c00;
      box-shadow: 0 0 0 0.2rem rgba(255, 140, 0, 0.25);
    }

    .form-label {
      color: #555;
    }

    .btn-orange {
      background-color: #ff8c00;
      color: white;
    }

    .btn-orange:hover {
      background-color: #e67600;
    }

    .text-warning {
      color: #ff8c00 !important;
    }
  </style>
</head>
<body>

<section class="container d-flex justify-content-center align-items-center">
  <div class="col-md-8 form-container">
    <h3 class="text-center text-warning mb-4 fw-bold">RR Herrería</h3>
    <p class="text-center mb-4">Registrar nuevo proveedor</p>

    <?php if (!empty($mensaje)): ?>
      <div class="alert alert-<?php echo $mensajeTipo; ?> alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($mensaje); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="mb-4">
        <input type="text" name="Nombre" class="form-control" required>
        <label class="form-label">Nombre del Proveedor</label>
      </div>

      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-orange me-md-2">Registrar</button>
        <a href="VerProveedores.php" class="btn btn-secondary">Salir</a>
      </div>
    </form>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

</body>
</html>
