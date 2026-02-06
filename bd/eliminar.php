<?php
include("configuracion.php");

$conexion = mysqli_connect($server, $username, $password, $database_name);
if (!$conexion) {
  die("Error de conexión: " . mysqli_connect_error());
}
mysqli_set_charset($conexion, "utf8");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
  mysqli_close($conexion);
  die("ID inválido. <a href='listar.php'>Volver</a>");
}

$stmt = mysqli_prepare($conexion, "DELETE FROM productos WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
  mysqli_stmt_close($stmt);
  mysqli_close($conexion);
  header("Location: listar.php");
  exit;
} else {
  echo "Error al eliminar: " . mysqli_error($conexion) . "<br>";
  echo "<a href='listar.php'>Volver</a>";
  mysqli_stmt_close($stmt);
  mysqli_close($conexion);
}
?>
