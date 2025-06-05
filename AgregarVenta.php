<?php
// Incluye tu archivo de conexión si está separado
require 'conexion.php'; 

// Ya tienes $pdo disponible aquí

try {
    $stmt = $pdo->query("SELECT idProducto, Nombre, PrecioVenta FROM Productos"); // Ajusta el nombre de tabla y campos según tu BD
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener productos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Venta</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f2f2f2;
      font-family: sans-serif;
    }

    .venta-container {
      max-width: 1000px;
      background: white;
      padding: 30px;
      border-radius: 16px;
      margin: 40px auto;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
    }

    .form-label {
      font-weight: bold;
    }

    .form-control,
    .form-select {
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .btn-orange {
      background-color: #ff8c00;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      transition: background-color 0.3s;
    }

    .btn-orange:hover {
      background-color: #e67600;
    }

    .remove-btn {
      cursor: pointer;
      color: red;
      font-size: 1.4rem;
      font-weight: bold;
    }

    .total-box {
      font-size: 1.5rem;
      font-weight: bold;
      color: #333;
      margin-top: 20px;
    }

    .producto-item {
      background-color: #fafafa;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

<div class="venta-container">
  <h2>Registrar Venta</h2>

  <form id="ventaForm" method="POST" action="procesar_venta.php">
    <div class="row mb-4">
      <div class="col-md-4">
        <label for="idCliente" class="form-label">ID Cliente</label>
        <input type="number" name="idCliente" id="idCliente" class="form-control" required>
      </div>
      <div class="col-md-4">
        <label for="idEmpleado" class="form-label">ID Empleado</label>
        <input type="number" name="idEmpleado" id="idEmpleado" class="form-control" required>
      </div>
      <div class="col-md-4">
        <label for="fechaVenta" class="form-label">Fecha</label>
        <input type="text" name="fechaVenta" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8">
        <div id="productosContainer">
          <h5 class="mb-3">Productos en la venta</h5>
          <!-- Items dinámicos aquí -->
        </div>
        <button type="button" class="btn btn-orange mt-3" id="agregarProductoBtn">Agregar Producto</button>
      </div>

      <div class="col-md-4">
        <div class="total-box">Total: $<span id="totalVenta">0.00</span> MXN</div>
      </div>
    </div>

    <div class="text-center mt-5">
      <button type="submit" class="btn-orange w-100">Procesar Venta</button>
    </div>
  </form>
</div>

<script>
  const productosDisponibles = <?php echo json_encode($productos); ?>;

  const productosContainer = document.getElementById('productosContainer');
  const agregarProductoBtn = document.getElementById('agregarProductoBtn');
  const totalVentaSpan = document.getElementById('totalVenta');

  function crearProductoItem() {
    const div = document.createElement('div');
    div.classList.add('row', 'align-items-center', 'producto-item');

    div.innerHTML = `
      <div class="col-md-6 mb-2">
        <select name="productos[][idProducto]" class="form-select producto-select" required>
          <option value="">Selecciona un producto</option>
          ${productosDisponibles.map(p => 
            `<option value="${p.idProducto}" data-precio="${p.PrecioVenta}">${p.Nombre}</option>`
          ).join('')}
        </select>
      </div>
      <div class="col-md-3 mb-2">
        <input type="number" name="productos[][Cantidad]" class="form-control cantidad-input" min="1" value="1" required>
      </div>
      <div class="col-md-2 mb-2 text-center">
        <span class="remove-btn" title="Quitar producto">&times;</span>
      </div>
    `;

    div.querySelector('.remove-btn').addEventListener('click', () => {
      div.remove();
      calcularTotal();
    });

    div.querySelector('.producto-select').addEventListener('change', calcularTotal);
    div.querySelector('.cantidad-input').addEventListener('input', calcularTotal);

    return div;
  }

  agregarProductoBtn.addEventListener('click', () => {
    const nuevoProducto = crearProductoItem();
    productosContainer.appendChild(nuevoProducto);
  });

  function calcularTotal() {
    let total = 0;
    document.querySelectorAll('.producto-item').forEach(item => {
      const select = item.querySelector('.producto-select');
      const cantidadInput = item.querySelector('.cantidad-input');
      const precio = parseFloat(select.selectedOptions[0]?.dataset.precio || 0);
      const cantidad = parseInt(cantidadInput.value) || 0;
      total += precio * cantidad;
    });
    totalVentaSpan.textContent = total.toFixed(2);
  }

  window.onload = () => {
    agregarProductoBtn.click();
  };
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
