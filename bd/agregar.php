<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar producto</title>
</head>

<body>

  <h2 id="A">Agregar Producto</h2>

  <form name="datos" id="datos" method="post" action="registro.php">
    
    Nombre:
    <br>
    <input type="text" name="nombre" required>
    <br><br>

    Presentación (ej: kg):
    <br>
    <input type="text" name="presentacion" required>
    <br><br>

    Precio:
    <br>
    <input type="number" name="precio" step="0.01" required>
    <br><br>

    Descripción:
    <br>
    <textarea name="descripcion" rows="4" required></textarea>
    <br><br>

    <input type="submit" value="Guardar Producto">

  </form>

</body>
</html>
