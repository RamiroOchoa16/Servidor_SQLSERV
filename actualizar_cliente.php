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

// Actualizar cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    $sql = "EXEC ActualizarCliente ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?";
    $stmt = $pdo->prepare($sql);
    $params = [
        $_POST['idCliente'],
        $_POST['Nombre'],
        $_POST['Paterno'],
        $_POST['Materno'],
        $_POST['Telefono'],
        $_POST['Email'],
        $_POST['Edad'],
        $_POST['Sexo'],
        $_POST['idDomicilio'],
        $_POST['Credito'],
        $_POST['Limite'],
        $_POST['idDescuento'] ?: null
    ];
    try {
        $stmt->execute($params);
        $mensaje = "✅ Cliente actualizado correctamente.";
    } catch (PDOException $e) {
        $mensaje = "❌ Error al actualizar: " . $e->getMessage();
    }
}

// Cargar cliente a editar
$clienteEdit = null;
if (isset($_GET['editar'])) {
    $sql = "
        SELECT TOP 1 c.idCliente, p.Nombre, p.Paterno, p.Materno, p.Telefono, p.Email, p.Edad, p.Sexo,
               p.idDomicilio, c.Credito, c.Limite, c.idDescuento
        FROM Clientes c
        JOIN Personas p ON c.idPersona = p.idPersona
        WHERE c.idCliente = ?
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['editar']]);
    $clienteEdit = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Obtener lista de clientes
$sql = "
    SELECT c.idCliente, p.Nombre, p.Paterno, p.Materno, c.Credito
    FROM Clientes c
    JOIN Personas p ON c.idPersona = p.idPersona
    WHERE p.Estatus IS NULL OR p.Estatus <> 'Inactivo'
";
$stmt = $pdo->query($sql);
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Clientes</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet"/>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: 'Segoe UI', sans-serif;
        }
        h2 {
            text-align: center;
            margin: 30px 0 20px;
        }
        .btn-orange {
            background-color: #ff8c00;
            color: white;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: bold;
        }
        .btn-orange:hover {
            background-color: #e67600;
        }
        .table thead {
            background-color: #343a40;
            color: white;
        }
        .table {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
        }
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 16px;
            max-width: 700px;
            margin: 40px auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input, select {
            border-radius: 10px !important;
            border: 1px solid #ccc;
        }
        .mensaje {
            text-align: center;
            font-weight: bold;
            margin: 20px auto;
        }
        .top-bar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container py-4">

    <div class="top-bar">
        <a href="pagina1.php" class="btn btn-outline-secondary">Salir</a>
    </div>

    <h2>Lista de Clientes</h2>

    <?php if (isset($mensaje)) echo "<div class='alert alert-info mensaje'>{$mensaje}</div>"; ?>

    <div class="table-responsive">
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Crédito</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cli): ?>
                <tr>
                    <td><?= $cli['idCliente'] ?></td>
                    <td><?= $cli['Nombre'] . ' ' . $cli['Paterno'] . ' ' . $cli['Materno'] ?></td>
                    <td>$<?= number_format($cli['Credito'], 2) ?></td>
                    <td><a href="?editar=<?= $cli['idCliente'] ?>" class="btn btn-sm btn-orange">Actualizar</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if ($clienteEdit): ?>
    <h2>Actualizar Cliente</h2>
    <div class="form-container">
        <form method="POST">
            <input type="hidden" name="idCliente" value="<?= $clienteEdit['idCliente'] ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="Nombre" class="form-control" placeholder="Nombre" value="<?= $clienteEdit['Nombre'] ?>" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="Paterno" class="form-control" placeholder="Apellido Paterno" value="<?= $clienteEdit['Paterno'] ?>" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="Materno" class="form-control" placeholder="Apellido Materno" value="<?= $clienteEdit['Materno'] ?>" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="Telefono" class="form-control" placeholder="Teléfono" value="<?= $clienteEdit['Telefono'] ?>" required>
                </div>
                <div class="col-md-6">
                    <input type="email" name="Email" class="form-control" placeholder="Email" value="<?= $clienteEdit['Email'] ?>" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="Edad" class="form-control" placeholder="Edad" value="<?= $clienteEdit['Edad'] ?>" required>
                </div>
                <div class="col-md-3">
                    <select name="Sexo" class="form-control" required>
                        <option value="H" <?= $clienteEdit['Sexo'] == 'H' ? 'selected' : '' ?>>Hombre</option>
                        <option value="M" <?= $clienteEdit['Sexo'] == 'M' ? 'selected' : '' ?>>Mujer</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="number" name="idDomicilio" class="form-control" placeholder="ID Domicilio" value="<?= $clienteEdit['idDomicilio'] ?>" required>
                </div>
                <div class="col-md-6">
                    <input type="number" step="0.01" name="Credito" class="form-control" placeholder="Crédito" value="<?= $clienteEdit['Credito'] ?>" required>
                </div>
                <div class="col-md-6">
                    <input type="number" step="0.01" name="Limite" class="form-control" placeholder="Límite" value="<?= $clienteEdit['Limite'] ?>" required>
                </div>
                <div class="col-md-6">
                    <input type="number" name="idDescuento" class="form-control" placeholder="ID Descuento" value="<?= $clienteEdit['idDescuento'] ?>">
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
