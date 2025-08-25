<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
include 'db.php';

$success = '';  // Variable para el mensaje de éxito

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_paciente = $_POST['paciente'];
    $id_doctor = $_POST['doctor'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    $sql = "INSERT INTO citas (id_paciente, id_doctor, fecha, hora) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $id_paciente, $id_doctor, $fecha, $hora);

    if ($stmt->execute()) {
        $success = "Cita agendada con éxito";
    } else {
        $success = "Error al agendar la cita";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Nueva Cita</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e8f4f8; /* Light Blue for hospital environment */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff; /* White */
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        h2 {
            color: #004d40; /* Dark Teal */
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            color: #00796b; /* Teal */
            font-weight: bold;
        }

        select, input[type="date"], input[type="time"] {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        button {
            padding: 10px 15px;
            background-color: #0097a7; 
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3; /* Darker Blue */
        }

        .back-btn {
            text-align: center;
            margin-top: 20px;
        }

        .back-btn a {
            text-decoration: none;
            color: #007bff;
            font-size: 18px;
            border: 1px solid #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .back-btn a:hover {
            background-color: #007bff;
            color: white;
        }

        /* Notificación emergente */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4caf50; /* Green */
            color: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            z-index: 1000;
        }

        .notification.success {
            background-color: #4caf50; /* Green */
        }

        .notification.error {
            background-color: #f44336; /* Red */
        }

        .notification .close-btn {
            margin-left: auto;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            line-height: 1;
            padding: 0 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Agendar Nueva Cita</h2>
        <form method="POST" action="">
            <!-- Seleccionar Paciente -->
            <label for="paciente">Seleccionar Paciente:</label>
            <select name="paciente" required>
                <?php
                // Consulta para obtener los pacientes
                $pacientes = $conn->query("SELECT id, nombre FROM pacientes");
                while ($paciente = $pacientes->fetch_assoc()) {
                    echo "<option value='" . $paciente['id'] . "'>" . $paciente['nombre'] . "</option>";
                }
                ?>
            </select>

            <!-- Seleccionar Doctor -->
            <label for="doctor">Seleccionar Doctor:</label>
            <select name="doctor" required>
                <?php
                // Consulta para obtener los doctores
                $doctores = $conn->query("SELECT id, nombre, especialidad FROM doctores");
                while ($doctor = $doctores->fetch_assoc()) {
                    echo "<option value='" . $doctor['id'] . "'>" . $doctor['nombre'] . " (" . $doctor['especialidad'] . ")</option>";
                }
                ?>
            </select>

            <!-- Fecha de la cita -->
            <label for="fecha">Fecha de la cita:</label>
            <input type="date" name="fecha" required>

            <!-- Hora de la cita -->
            <label for="hora">Hora de la cita:</label>
            <input type="time" name="hora" required>

            <!-- Botón de agendar -->
            <button type="submit">Agendar Cita</button>
        </form>

        <!-- Botón para volver al menú -->
        <div class="back-btn">
            <a href="menu.php">Volver al Menú</a>
        </div>

        <!-- Notificación emergente -->
        <?php if (!empty($success)): ?>
            <div class="notification success">
                <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                <?php echo $success; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        setTimeout(function() {
            var notification = document.querySelector('.notification');
            if (notification) {
                notification.style.display = 'none';
            }
        }, 5000);
    </script>
</body>
</html>

