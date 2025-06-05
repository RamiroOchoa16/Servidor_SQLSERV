<?php require_once 'conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $hash = hash("sha256", $_POST["Contrasena"]);
        $c_CP = intval($_POST["c_CP"]);

        $stmt = $pdo->prepare("EXEC RegistrarEmpleado 
          @Nombre = ?, @Paterno = ?, @Materno = ?, 
          @Telefono = ?, @Email = ?, @Edad = ?, @Sexo = ?, 
          @Calle = ?, @Numero = ?, @c_CP = ?, 
          @RFC = ?, @CURP = ?, @NumeroSeguro = ?, 
          @Usuario = ?, @Contrasena = ?, @Puesto = ?");

        $stmt->execute([
          $_POST["Nombre"],
          $_POST["Paterno"],
          $_POST["Materno"],
          $_POST["Telefono"],
          $_POST["Email"],
          $_POST["Edad"],
          $_POST["Sexo"],
          $_POST["Calle"],
          $_POST["Numero"],
          $c_CP,
          $_POST["RFC"],
          $_POST["CURP"],
          $_POST["NumeroSeguro"],
          $_POST["Usuario"],
          $hash,
          $_POST["Puesto"]
        ]);

        echo "<script>
              alert('Empleado registrado con éxito.');
              window.location.href = 'pagina1.php';
            </script>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger mt-3'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Empleado</title>
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
  <div class="col-lg-10 form-container">
    <h3 class="text-center text-warning mb-4 fw-bold">RR Herrería</h3>
    <p class="text-center mb-4">Registrar nuevo empleado</p>

    <form method="POST" action="">
      <div class="row">
        <div class="col-md-4 mb-4"><input type="text" name="Nombre" class="form-control" required><label class="form-label">Nombre</label></div>
        <div class="col-md-4 mb-4"><input type="text" name="Paterno" class="form-control" required><label class="form-label">Apellido Paterno</label></div>
        <div class="col-md-4 mb-4"><input type="text" name="Materno" class="form-control" required><label class="form-label">Apellido Materno</label></div>
      </div>
      <div class="row">
        <div class="col-md-4 mb-4"><input type="text" name="Telefono" class="form-control" required><label class="form-label">Teléfono</label></div>
        <div class="col-md-4 mb-4"><input type="email" name="Email" class="form-control" required><label class="form-label">Email</label></div>
        <div class="col-md-4 mb-4"><input type="number" name="Edad" class="form-control" required><label class="form-label">Edad</label></div>
      </div>
      <div class="row">
        <div class="col-md-4 mb-4">
          <select name="Sexo" class="form-select" required>
            <option value="H">Hombre</option>
            <option value="M">Mujer</option>
          </select>
          <label class="form-label">Sexo</label>
        </div>
        <div class="col-md-4 mb-4"><input type="text" name="Calle" class="form-control" required><label class="form-label">Calle</label></div>
        <div class="col-md-4 mb-4"><input type="number" name="Numero" class="form-control" required><label class="form-label">Número</label></div>
      </div>
      <div class="row"> 
        <div class="col-md-6 mb-4">
          <label for="Puesto" class="form-label">Puesto</label>
          <select name="Puesto" class="form-select" required>
            <option value="">Selecciona un puesto</option>
            <option value="Cajero">Cajero</option>
            <option value="Agente de Venta">Agente de Venta</option>
          </select>
        </div>
        <div class="col-md-6 mb-4">
          <label for="codigoPostal" class="form-label">Código Postal</label>
          <input type="text" class="form-control" id="codigoPostal" name="codigoPostal" required>
        </div>
      </div>

      <div class="mb-3" id="asentamientosContainer" style="display:none;">
        <label for="asentamiento" class="form-label">Asentamiento</label>
        <select class="form-select" id="asentamiento" name="idAsentamiento" required></select>
      </div>
      <input type="hidden" name="c_CP" id="c_CP" />

      <div class="row"> 
        <div class="col-md-4 mb-4"><label for="estado" class="form-label">Estado</label><input type="text" class="form-control" id="estado" disabled></div>
        <div class="col-md-4 mb-4"><label for="municipio" class="form-label">Municipio</label><input type="text" class="form-control" id="municipio" disabled></div>
        <div class="col-md-4 mb-4"><label for="pais" class="form-label">País</label><input type="text" class="form-control" id="pais" disabled></div>
      </div>

      <div class="row">
        <div class="col-md-4 mb-4"><input type="text" name="RFC" class="form-control" required><label class="form-label">RFC</label></div>
        <div class="col-md-4 mb-4"><input type="text" name="CURP" class="form-control"><label class="form-label">CURP</label></div>
        <div class="col-md-4 mb-4"><input type="text" name="NumeroSeguro" class="form-control" required><label class="form-label">NSS</label></div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-4"><input type="text" name="Usuario" class="form-control" required><label class="form-label">Usuario</label></div>
        <div class="col-md-6 mb-4"><input type="password" name="Contrasena" class="form-control" required><label class="form-label">Contraseña</label></div>
      </div>

      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-orange me-md-2">Registrar</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='pagina1.php'">Salir</button>
      </div>
    </form>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('codigoPostal').addEventListener('blur', function() {
    let cp = this.value;
    if (cp.length === 5) {
      fetch('consulta_cp.php?cp=' + cp)
        .then(response => response.json())
        .then(data => {
          const asentamientos = document.getElementById('asentamiento');
          asentamientos.innerHTML = '';
          if (data.length > 0) {
            data.forEach(item => {
              let option = document.createElement('option');
              option.value = item.idAsentamiento;
              option.text = item.Asentamiento;
              option.dataset.estado = item.Estado;
              option.dataset.municipio = item.Municipio;
              option.dataset.pais = item.Pais;
              option.dataset.ccp = item.c_CP;
              asentamientos.appendChild(option);
            });

            document.getElementById('asentamientosContainer').style.display = 'block';
            let first = asentamientos.options[0];
            document.getElementById('estado').value = first.dataset.estado;
            document.getElementById('municipio').value = first.dataset.municipio;
            document.getElementById('pais').value = first.dataset.pais;
            document.getElementById('c_CP').value = first.dataset.ccp;

            asentamientos.addEventListener('change', function() {
              let selected = asentamientos.options[asentamientos.selectedIndex];
              document.getElementById('estado').value = selected.dataset.estado;
              document.getElementById('municipio').value = selected.dataset.municipio;
              document.getElementById('pais').value = selected.dataset.pais;
              document.getElementById('c_CP').value = selected.dataset.ccp;
            });
          } else {
            document.getElementById('asentamientosContainer').style.display = 'none';
            document.getElementById('estado').value = '';
            document.getElementById('municipio').value = '';
            document.getElementById('pais').value = '';
            document.getElementById('c_CP').value = '';
          }
        });
    }
  });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

</body>
</html>
