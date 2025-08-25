<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
include 'db.php';

$success = '';  // Variable para el mensaje de éxito

if (isset($_POST['add_doctor'])) {
    $nombre = $_POST['doctorName'];
    $especialidad = $_POST['specialty'];

    $sql = "INSERT INTO doctores (nombre, especialidad) VALUES ('$nombre', '$especialidad')";
    if ($conn->query($sql) === TRUE) {
        $success = "Doctor añadido correctamente";
    } else {
        $success = "Error al añadir el doctor";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Doctor</title>
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
            gap: 15px;
        }

        label {
            font-size: 16px;
            color: #00796b; /* Teal */
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"] {
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

        /* Estilos para la notificación emergente */
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Añadir Doctor</h2>
        <form method="post" action="">
            <label for="doctorName">Nombre del Doctor:</label>
            <input type="text" id="doctorName" name="doctorName" required>

            <label for="specialty">Especialidad:</label>
            <input type="text" id="specialty" name="specialty" required>

            <button type="submit" name="add_doctor">Añadir Doctor</button>
        </form>

        <!-- Notificación emergente -->
        <?php if (!empty($success)): ?>
            <div class="notification success">
                <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <!-- Botón para volver al menú -->
        <div class="back-btn">
            <a href="menu.php">Volver al Menú</a>
        </div>
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
