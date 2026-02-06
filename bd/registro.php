<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>

<!DOCTYPE HTML>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Registro de Producto</title>
</head>

<body>
<p id="O"></p>

<?php
$nombre       = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$presentacion = isset($_POST['presentacion']) ? trim($_POST['presentacion']) : '';
$precio       = isset($_POST['precio']) ? trim($_POST['precio']) : '';
$descripcion  = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';

if ($nombre === '' || $presentacion === '' || $precio === '' || $descripcion === '') {
  echo "<br/><br/>";
  echo "Faltan datos. Verifica el formulario.<br/>";
  echo "<a href='parcialbd.html'>Volver</a>";
  exit;
}

include("configuracion.php");

$conexion = mysqli_connect($server, $username, $password, $database_name);
if (!$conexion) {
  die("Error de conexión: " . mysqli_connect_error());
}

$precio = (float)$precio;

// Verificar duplicado (opcional)
$stmt = mysqli_prepare($conexion, "SELECT id FROM productos WHERE nombre = ? AND presentacion = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "ss", $nombre, $presentacion);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
  echo "<br/><br/>";
  echo "Ese producto ya está registrado (mismo nombre y presentación).<br/>";
  echo "<a href='parcialbd.html'>Volver</a>";
  mysqli_stmt_close($stmt);
  mysqli_close($conexion);
  exit;
}
mysqli_stmt_close($stmt);

// Insertar
$stmt = mysqli_prepare($conexion, "INSERT INTO productos (nombre, presentacion, precio, descripcion) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssds", $nombre, $presentacion, $precio, $descripcion);

if (mysqli_stmt_execute($stmt)) {
  echo "<br/><br/>";
  echo "✅ El producto fue registrado satisfactoriamente<br/>";
  echo "<a href='parcialbd.html'>Volver</a> | <a href='listar.php'>Ver productos</a>";
} else {
  echo "<br/><br/>";
  echo "❌ Error al registrar: " . mysqli_error($conexion) . "<br/>";
  echo "<a href='parcialbd.html'>Volver</a>";
}

mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>
</body>
</html>
