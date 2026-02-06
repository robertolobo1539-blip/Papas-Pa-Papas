<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Producto</title>
</head>
<body>

<h2>Editar Producto</h2>

<?php
include("configuracion.php");

$conexion = mysqli_connect($server, $username, $password, $database_name);
if (!$conexion) {
  die("Error de conexión: " . mysqli_connect_error());
}
mysqli_set_charset($conexion, "utf8");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
  die("ID inválido. <a href='listar.php'>Volver</a>");
}

// Si se envió el formulario, actualiza
if (isset($_POST['guardar'])) {
  $nombre = trim($_POST['nombre']);
  $presentacion = trim($_POST['presentacion']);
  $precio = (float)$_POST['precio'];
  $descripcion = trim($_POST['descripcion']);

  if ($nombre === '' || $presentacion === '' || $descripcion === '') {
    echo "Faltan datos. <a href='editar.php?id=$id'>Volver</a>";
    mysqli_close($conexion);
    exit;
  }

  $stmt = mysqli_prepare($conexion, "UPDATE productos SET nombre=?, presentacion=?, precio=?, descripcion=? WHERE id=?");
  mysqli_stmt_bind_param($stmt, "ssdsi", $nombre, $presentacion, $precio, $descripcion, $id);

  if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
    header("Location: listar.php");
    exit;
  } else {
    echo "Error al actualizar: " . mysqli_error($conexion);
    mysqli_stmt_close($stmt);
  }
}

// Cargar datos del producto
$stmt = mysqli_prepare($conexion, "SELECT nombre, presentacion, precio, descripcion FROM productos WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $nombre, $presentacion, $precio, $descripcion);

if (!mysqli_stmt_fetch($stmt)) {
  die("No se encontró el producto. <a href='listar.php'>Volver</a>");
}
mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>

<form method="post">
  Nombre:<br>
  <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required><br><br>

  Presentación:<br>
  <input type="text" name="presentacion" value="<?php echo htmlspecialchars($presentacion); ?>" required><br><br>

  Precio:<br>
  <input type="number" step="0.01" name="precio" value="<?php echo htmlspecialchars($precio); ?>" required><br><br>

  Descripción:<br>
  <textarea name="descripcion" rows="4" required><?php echo htmlspecialchars($descripcion); ?></textarea><br><br>

  <button type="submit" name="guardar">Guardar cambios</button>
</form>

<br>
<a href="listar.php">Volver al listado</a>

</body>
</html>
