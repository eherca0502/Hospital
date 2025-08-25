<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
include 'db.php';

$success = '';  // Variable para el mensaje de éxito

if (isset($_POST['add_patient'])) {
    $nombre = $_POST['patientName'];
    $fecha_ingreso = $_POST['admissionDate'];

    $sql = "INSERT INTO pacientes (nombre, fecha_ingreso) VALUES ('$nombre', '$fecha_ingreso')";
    if ($conn->query($sql) === TRUE) {
        $success = "Paciente añadido correctamente";
    } else {
        $success = "Error al añadir el paciente";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Paciente</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f8ff; /* Light Alice Blue background */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            color: #004d40; /* Dark Teal */
            text-align: center;
        }

        form {
            background-color: #ffffff; /* White background for form */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            color: #00796b; /* Teal */
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background-color: #0097a7; /* Teal */
            color: white;
            border: none;
            padding: 15px 20px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #00796b; /* Darker Teal */
        }

        .notification {
            background-color: #d4edda; /* Light Green */
            color: #155724; /* Dark Green */
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
            position: relative;
        }

        .notification.success {
            background-color: #d4edda; /* Light Green */
            color: #155724; /* Dark Green */
        }

        .notification .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
        }

        .back-btn {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Añadir Paciente</h2>
        <form method="post" action="">
            <label for="patientName">Nombre del Paciente:</label>
            <input type="text" id="patientName" name="patientName" required>

            <label for="admissionDate">Fecha de Ingreso:</label>
            <input type="date" id="admissionDate" name="admissionDate" required>

            <button type="submit" name="add_patient">Añadir Paciente</button>
        </form>

        <!-- Botón para volver al menú -->
        <div class="back-btn">
            <form action="menu.php" method="get">
                <button type="submit">Volver al Menú</button>
            </form>
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
