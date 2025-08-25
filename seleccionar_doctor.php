<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Citas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Ver Citas por Doctor</h2>

    <!-- Formulario para seleccionar el doctor -->
    <form method="POST" action="ver_citas.php">
        <label for="doctor">Seleccionar Doctor:</label>
        <select name="doctor" required>
            <?php
            // Obtener la lista de doctores
            $doctores = $conn->query("SELECT id, nombre, especialidad FROM doctores");
            while ($doctor = $doctores->fetch_assoc()) {
                echo "<option value='" . $doctor['id'] . "'>" . $doctor['nombre'] . " (" . $doctor['especialidad'] . ")</option>";
            }
            ?>
        </select>
        <button type="submit">Ver Citas</button>
    </form>

    <!-- Botón para volver al menú -->
    <form action="menu.php" method="get">
        <button type="submit">Volver al Menú</button>
    </form>
</body>
</html>
