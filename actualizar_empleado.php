<?php
$dsn = "sqlsrv:Server=sqlserver_container,1433;Database=HerreriaRR";
$user = "sa";
$password = "TuPassword123!";

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión PDO: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    $sql = "EXEC ActualizarEmpleado ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?";
    $stmt = $pdo->prepare($sql);
    $params = [
        $_POST['idEmpleado'],
        $_POST['Nombre'],
        $_POST['Paterno'],
        $_POST['Materno'],
        $_POST['Telefono'],
        $_POST['Email'],
        $_POST['Edad'],
        $_POST['Sexo'],
        $_POST['idDomicilio'],
        $_POST['Puesto'],
        $_POST['RFC'],
        $_POST['NumeroSeguroSocial'],
        $_POST['Usuario']
    ];
    try {
        $stmt->execute($params);
        $mensaje = "✅ Empleado actualizado correctamente.";
    } catch (PDOException $e) {
        $mensaje = "❌ Error al actualizar: " . $e->getMessage();
    }
}

$empleadoEdit = null;
if (isset($_GET['editar'])) {
    $sql = "
        SELECT TOP 1 e.idEmpleado, p.Nombre, p.Paterno, p.Materno, p.Telefono, p.Email, p.Edad, p.Sexo,
               d.idDomicilio, e.Puesto, e.RFC, e.NumeroSeguroSocial, e.Usuario
        FROM Empleados e
        JOIN Personas p ON e.idPersona = p.idPersona
        JOIN Domicilios d ON p.idDomicilio = d.idDomicilio
        WHERE e.idEmpleado = ?
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['editar']]);
    $empleadoEdit = $stmt->fetch(PDO::FETCH_ASSOC);
}

$sql = "
    SELECT e.idEmpleado, p.Nombre, p.Paterno, p.Materno, e.Puesto
    FROM Empleados e
    JOIN Personas p ON e.idPersona = p.idPersona
";
$stmt = $pdo->query($sql);
$empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Empleados</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet"/>
    <style>
        body {
            background-color: #f8f9fa;
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
            color: white;
        }
        .card {
            border-radius: 16px;
        }
        .form-control {
            border-radius: 12px;
        }
        .mensaje {
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container py-5">

    <!-- Botón Salir -->
    <div class="d-flex justify-content-end mb-3">
        <a href="pagina1.php" class="btn btn-outline-secondary">Salir</a>
    </div>

    <h2 class="mb-4 text-center">Lista de Empleados</h2>

    <?php if (isset($mensaje)) echo "<div class='alert alert-info mensaje'>{$mensaje}</div>"; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover rounded shadow-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Puesto</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($empleados as $emp): ?>
                <tr>
                    <td><?= $emp['idEmpleado'] ?></td>
                    <td><?= $emp['Nombre'] . ' ' . $emp['Paterno'] . ' ' . $emp['Materno'] ?></td>
                    <td><?= $emp['Puesto'] ?></td>
                    <td><a class="btn btn-sm btn-orange" href="?editar=<?= $emp['idEmpleado'] ?>">Actualizar</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if ($empleadoEdit): ?>
    <h2 class="text-center mt-5">Actualizar Empleado</h2>
    <div class="card shadow p-4 mx-auto mt-3" style="max-width: 700px;">
        <form method="POST">
            <input type="hidden" name="idEmpleado" value="<?= $empleadoEdit['idEmpleado'] ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="Nombre" class="form-control" placeholder="Nombre" value="<?= $empleadoEdit['Nombre'] ?>" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="Paterno" class="form-control" placeholder="Apellido Paterno" value="<?= $empleadoEdit['Paterno'] ?>" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="Materno" class="form-control" placeholder="Apellido Materno" value="<?= $empleadoEdit['Materno'] ?>" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="Telefono" class="form-control" placeholder="Teléfono" value="<?= $empleadoEdit['Telefono'] ?>" required>
                </div>
                <div class="col-md-6">
                    <input type="email" name="Email" class="form-control" placeholder="Email" value="<?= $empleadoEdit['Email'] ?>" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="Edad" class="form-control" placeholder="Edad" value="<?= $empleadoEdit['Edad'] ?>" required>
                </div>
                <div class="col-md-3">
                    <select name="Sexo" class="form-control" required>
                        <option value="H" <?= $empleadoEdit['Sexo'] == 'H' ? 'selected' : '' ?>>Hombre</option>
                        <option value="M" <?= $empleadoEdit['Sexo'] == 'M' ? 'selected' : '' ?>>Mujer</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="number" name="idDomicilio" class="form-control" placeholder="ID Domicilio" value="<?= $empleadoEdit['idDomicilio'] ?>" required>
                </div>
                <div class="col-md-6">
                    <select name="Puesto" class="form-control" required>
                        <option value="Administrador" <?= $empleadoEdit['Puesto'] == 'Administrador' ? 'selected' : '' ?>>Administrador</option>
                        <option value="Cajero" <?= $empleadoEdit['Puesto'] == 'Cajero' ? 'selected' : '' ?>>Cajero</option>
                        <option value="Agente de Venta" <?= $empleadoEdit['Puesto'] == 'Agente de Venta' ? 'selected' : '' ?>>Agente de Venta</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" name="RFC" class="form-control" placeholder="RFC" value="<?= $empleadoEdit['RFC'] ?>" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="NumeroSeguroSocial" class="form-control" placeholder="NSS" value="<?= $empleadoEdit['NumeroSeguroSocial'] ?>" required>
                </div>
                <div class="col-md-12">
                    <input type="text" name="Usuario" class="form-control" placeholder="Usuario" value="<?= $empleadoEdit['Usuario'] ?>" required>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" name="actualizar" class="btn btn-orange mt-3">Guardar cambios</button>
                </div>
            </div>
        </form>
    </div>
    <?php endif; ?>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
</body>
</html>
