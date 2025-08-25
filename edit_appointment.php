<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Consulta para obtener la información de la cita
    $sql = "SELECT * FROM citas WHERE id='$id'";
    $result = $conn->query($sql);
    $cita = $result->fetch_assoc();
}

// Consulta para obtener la lista de pacientes y doctores
$pacientes = $conn->query("SELECT id, nombre FROM pacientes");
$doctores = $conn->query("SELECT id, nombre, especialidad FROM doctores");

if (isset($_POST['update_cita'])) {
    $paciente_id = $_POST['paciente'];
    $doctor_id = $_POST['doctor'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    // Consulta para actualizar la cita
    $sql = "UPDATE citas SET id_paciente='$paciente_id', id_doctor='$doctor_id', fecha='$fecha', hora='$hora' WHERE id='$id'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: view_appointment.php");
        exit();
    } else {
        $error = "Error al actualizar la cita.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Cita</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Modificar Cita</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <!-- Seleccionar Paciente -->
            <label for="paciente">Seleccionar Paciente:</label>
            <select id="paciente" name="paciente" required>
                <?php while ($paciente = $pacientes->fetch_assoc()) { ?>
                    <option value="<?php echo $paciente['id']; ?>" 
                        <?php echo ($paciente['id'] == $cita['id_paciente']) ? 'selected' : ''; ?>>
                        <?php echo $paciente['nombre']; ?>
                    </option>
                <?php } ?>
            </select><br>

            <!-- Seleccionar Doctor -->
            <label for="doctor">Seleccionar Doctor:</label>
            <select id="doctor" name="doctor" required>
                <?php while ($doctor = $doctores->fetch_assoc()) { ?>
                    <option value="<?php echo $doctor['id']; ?>" 
                        <?php echo ($doctor['id'] == $cita['id_doctor']) ? 'selected' : ''; ?>>
                        <?php echo $doctor['nombre'] . " (" . $doctor['especialidad'] . ")"; ?>
                    </option>
                <?php } ?>
            </select><br>

            <!-- Fecha de la cita -->
            <label for="fecha">Fecha de la Cita:</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo htmlspecialchars($cita['fecha']); ?>" required><br>

            <!-- Hora de la cita -->
            <label for="hora">Hora de la Cita:</label>
            <input type="time" id="hora" name="hora" value="<?php echo htmlspecialchars($cita['hora']); ?>" required><br>

            <button type="submit" name="update_cita">Actualizar Cita</button>
        </form>
        <a href="view_appointment.php">Volver a la lista de Citas</a>
    </div>
