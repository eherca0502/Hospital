<?php
// Inicia la sesión y conecta a la base de datos
session_start();
include 'db.php';

// Comprueba si el método de la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoge los datos del formulario
    $id_paciente = $_POST['paciente'];
    $id_doctor = $_POST['doctor'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    // Prepara la consulta SQL para insertar la cita
    $sql = "INSERT INTO citas (id_paciente, id_doctor, fecha, hora) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $id_paciente, $id_doctor, $fecha, $hora);

    // Ejecuta la consulta e informa si se ha agendado la cita o no
    if ($stmt->execute()) {
        $message = "Cita agendada con éxito.";
        $alert_type = "success";  // Clase CSS para mensaje verde
    } else {
        $message = "Error al agendar la cita.";
        $alert_type = "error";  // Clase CSS para mensaje rojo
    }

    // Cierra la declaración preparada
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita</title>
    <!-- Vinculación del archivo styles.css -->
    <link rel="stylesheet" href="styles.css">

    <!-- Añade un estilo para las notificaciones emergentes -->
    <style>
        .alert {
            padding: 15px;
            background-color: #f44336;
            color: white;
            margin-bottom: 15px;
            display: none; /* Por defecto, oculta el mensaje */
        }

        .success {
            background-color: #4CAF50; /* Verde para éxito */
        }

        .error {
            background-color: #f44336; /* Rojo para error */
        }

        .alert.show {
            display: block; /* Muestra el mensaje cuando sea necesario */
        }
    </style>
</head>
<body>
    <?php if (isset($message)): ?>
        <div class="alert <?php echo $alert_type; ?> show">
            <?php echo $message; ?>
        </div>

        <!-- Temporizador para ocultar el mensaje después de 5 segundos -->
        <script>
            setTimeout(function() {
                document.querySelector('.alert').classList.remove('show');
            }, 5000);
        </script>
    <?php endif; ?>

    <!-- Botón para volver al formulario de nueva cita -->
    <form action="new_appointment.php" method="get">
        <button type="submit">Volver a Nueva Cita</button>
    </form>
</body>
</html>

