<?php
include("configuracion.php");

$conexion = mysqli_connect($server, $username, $password, $database_name);
if (!$conexion) {
  die("Error de conexión: " . mysqli_connect_error());
}
mysqli_set_charset($conexion, "utf8");

// Traer productos
$sql = "SELECT id, nombre, presentacion, precio, descripcion FROM productos ORDER BY id DESC";
$result = mysqli_query($conexion, $sql);
if (!$result) {
  die("Error al consultar: " . mysqli_error($conexion));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lista de Productos</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    h2 { margin-bottom: 15px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #ccc; padding: 10px; vertical-align: top; }
    th { background: #f2f2f2; }
    .acciones a {
      display: inline-block;
      margin-right: 8px;
      padding: 6px 10px;
      text-decoration: none;
      border-radius: 4px;
      color: white;
      font-size: 14px;
    }
    .btn-editar { background: #2d7ff9; }
    .btn-eliminar { background: #e74c3c; }
    .btn-agregar { background: #27ae60; color: #fff; padding: 8px 12px; border-radius: 4px; text-decoration: none; }
    .topbar { display:flex; align-items:center; justify-content:space-between; gap:10px; margin-bottom: 12px; }
    .desc { max-width: 520px; }
  </style>
</head>
<body>

  <div class="topbar">
    <h2>Productos registrados</h2>
    <a class="btn-agregar" href="paralabd.html">+ Agregar producto</a>
  </div>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Presentación</th>
        <th>Precio</th>
        <th>Descripción</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
    <?php if (mysqli_num_rows($result) == 0): ?>
      <tr>
        <td colspan="6">No hay productos registrados.</td>
      </tr>
    <?php else: ?>
      <?php while ($fila = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?php echo (int)$fila["id"]; ?></td>
          <td><?php echo htmlspecialchars($fila["nombre"]); ?></td>
          <td><?php echo htmlspecialchars($fila["presentacion"]); ?></td>
          <td><?php echo number_format((float)$fila["precio"], 2); ?></td>
          <td class="desc"><?php echo htmlspecialchars($fila["descripcion"]); ?></td>
          <td class="acciones">
            <a class="btn-editar" href="editar.php?id=<?php echo (int)$fila['id']; ?>">Editar</a>
            <a class="btn-eliminar"
               href="eliminar.php?id=<?php echo (int)$fila['id']; ?>"
               onclick="return confirm('¿Seguro que deseas eliminar este producto?');">
               Eliminar
            </a>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php endif; ?>
    </tbody>
  </table>

</body>
</html>
<?php mysqli_close($conexion); ?>
