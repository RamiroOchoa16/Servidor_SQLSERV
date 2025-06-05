<?php require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $c_CP = intval(trim($_POST["c_CP"])); // Conversión segura

        $stmt = $pdo->prepare("EXEC RegistrarCliente 
            @Calle = ?, @Numero = ?, @c_CP = ?, 
            @Nombre = ?, @Paterno = ?, @Materno = ?, 
            @Telefono = ?, @Email = ?, @Edad = ?, @Sexo = ?, 
            @Credito = ?, @Limite = ?, @idDescuento = ?");

        $stmt->execute([
            $_POST["Calle"],
            $_POST["Numero"],
            $c_CP,
            $_POST["Nombre"],
            $_POST["Paterno"],
            $_POST["Materno"],
            $_POST["Telefono"],
            $_POST["Email"],
            $_POST["Edad"],
            $_POST["Sexo"],
            $_POST["Credito"],
            $_POST["Limite"],
            $_POST["idDescuento"]
        ]);

        echo "<script>
                alert('Cliente registrado con éxito.');
                window.location.href = 'VerClientes.php';
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
  <title>Registro de Cliente</title>
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

    .form-control,
    .form-select {
      background-color: #f7f7f7;
      border: 1px solid #ccc;
      color: #333;
    }

    .form-control:focus,
    .form-select:focus {
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
    <p class="text-center mb-4">Registrar nuevo cliente</p>

    <form method="POST">
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
          <label class="form-label">Código Postal</label>
          <input type="text" class="form-control" id="codigoPostal" name="codigoPostal" required>
        </div>
        <div class="col-md-6 mb-4">
          <label class="form-label">Asentamiento</label>
          <select class="form-select" id="asentamiento" name="idAsentamiento" required></select>
        </div>
      </div>

      <input type="hidden" name="c_CP" id="c_CP" />

      <div class="row">
        <div class="col-md-4 mb-4"><label class="form-label">Estado</label><input type="text" class="form-control" id="estado" disabled></div>
        <div class="col-md-4 mb-4"><label class="form-label">Municipio</label><input type="text" class="form-control" id="municipio" disabled></div>
        <div class="col-md-4 mb-4"><label class="form-label">País</label><input type="text" class="form-control" id="pais" disabled></div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-4"><input type="number" name="Credito" class="form-control" required><label class="form-label">Crédito</label></div>
        <div class="col-md-6 mb-4"><input type="number" name="Limite" class="form-control" required><label class="form-label">Límite de crédito</label></div>
      </div>

      <div class="mb-4">
        <label class="form-label">Descuento</label>
        <select class="form-select" name="idDescuento" required>
          <option value="">Seleccione un descuento</option>
          <option value="1">Sin descuento</option>
          <option value="2">5%</option>
          <option value="3">10%</option>
        </select>
      </div>

      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-orange me-md-2">Registrar</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='VerClientes.php'">Cancelar</button>
      </div>
    </form>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('codigoPostal').addEventListener('blur', function () {
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
            let first = asentamientos.options[0];
            document.getElementById('estado').value = first.dataset.estado;
            document.getElementById('municipio').value = first.dataset.municipio;
            document.getElementById('pais').value = first.dataset.pais;
            document.getElementById('c_CP').value = first.dataset.ccp;

            asentamientos.addEventListener('change', function () {
              let selected = asentamientos.options[asentamientos.selectedIndex];
              document.getElementById('estado').value = selected.dataset.estado;
              document.getElementById('municipio').value = selected.dataset.municipio;
              document.getElementById('pais').value = selected.dataset.pais;
              document.getElementById('c_CP').value = selected.dataset.ccp;
            });
          } else {
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
