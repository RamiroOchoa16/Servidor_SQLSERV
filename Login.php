<?php
require_once 'conexion.php'; // Ajusta la ruta a tu archivo de conexión PDO
session_start();

$usuarioInput = $_POST['usuario'] ?? '';
$claveInput = $_POST['contrasena'] ?? '';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM Empleados WHERE Usuario = ?");
    $stmt->execute([$usuarioInput]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $hashAlmacenado = $usuario['Contraseña'];

        if (password_verify($claveInput, $hashAlmacenado)) {
            iniciarSesion($usuario);
        } elseif (hash("sha256", $claveInput) === $hashAlmacenado) {
            // Migración de hash antiguo a password_hash()
            $nuevoHash = password_hash($claveInput, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE Empleados SET Contraseña = ? WHERE idEmpleado = ?");
            $update->execute([$nuevoHash, $usuario['idEmpleado']]);
            iniciarSesion($usuario);
        } else {
            $mensaje = "Contraseña incorrecta.";
        }
    } else {
        $mensaje = "Usuario no encontrado.";
    }
}

function iniciarSesion($usuario) {
    $_SESSION['idEmpleado'] = $usuario['idEmpleado'];
    $_SESSION['Usuario'] = $usuario['Usuario'];
    $_SESSION['Puesto'] = $usuario['Puesto'];

    if (strtolower(trim($usuario['Usuario'])) === 'ochoa') {
        header("Location: pagina1.php");
        exit();
    }
    switch (strtolower(trim($usuario['Puesto']))) {
        case 'administrador':
            header("Location: pagina1.php");
            break;
        case 'agentedeventa':
            header("Location: pagina2.php");
            break;
        case 'cajero':
            header("Location: pagina3.php");
            break;
        default:
            header("Location: dashboard.php");
            break;
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f2f2f2;
            font-family: sans-serif;
        }
        .login-container {
            max-width: 400px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            margin: 60px auto;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        .form-control {
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        .btn-orange {
            background-color: #ff8c00;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 6px;
            transition: background-color 0.3s;
        }
        .btn-orange:hover {
            background-color: #e67600;
        }
        .mensaje {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            color: red;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Iniciar Sesión</h2>

    <?php if (!empty($mensaje)) : ?>
        <div class="mensaje"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuario</label>
            <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Usuario" required>
        </div>

        <div class="mb-4">
            <label for="contrasena" class="form-label">Contraseña</label>
            <input type="password" name="contrasena" id="contrasena" class="form-control" placeholder="Contraseña" required>
        </div>

        <button type="submit" class="btn-orange">Iniciar Sesión</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
