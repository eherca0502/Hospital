<?php
session_start();
include 'db.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirigir al login si no está autenticado
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f8ff; /* Light Alice Blue background */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #4b9cd3; /* Light Blue background */
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        .header h2 {
            margin: 0;
            font-size: 24px;
            color: #ffffff; /* White text color for the header */
        }

        .header .username {
            color: #FFFFFF; 
            font-weight: bold;
        }

        .header .time {
            font-size: 18px;
            font-weight: bold;
        }

        ul.menu {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap; /* Ensure menu items wrap on smaller screens */
        }

        ul.menu li {
            display: inline-block;
        }

        ul.menu li a {
            text-decoration: none;
            color: #fff;
            font-size: 18px;
            padding: 12px 25px;
            border-radius: 30px;
            background-color: #0097a7; /* Teal background for buttons */
            border: 1px solid transparent;
            transition: background-color 0.3s, box-shadow 0.3s;
            box-shadow: 0px 4px 10px rgba(0, 151, 167, 0.2); /* Subtle shadow */
        }

        ul.menu li a:hover {
            background-color: #00796b; /* Darker Teal for hover effect */
            box-shadow: 0px 6px 12px rgba(0, 151, 167, 0.3);
        }

        .logout-btn {
            text-align: center;
            margin-top: 20px;
        }

        .logout-btn a {
            text-decoration: none;
            color: white;
            background-color: #e57373; /* Light Red background for logout button */
            padding: 12px 30px;
            border-radius: 30px;
            font-size: 18px;
            transition: background-color 0.3s, box-shadow 0.3s;
            box-shadow: 0px 4px 10px rgba(229, 115, 115, 0.2); /* Subtle shadow */
        }

        .logout-btn a:hover {
            background-color: #d32f2f; /* Darker Red for hover effect */
            box-shadow: 0px 6px 12px rgba(229, 115, 115, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Bienvenido  <span class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></span>!</h2>
            <div class="time" id="current-time">Hora: <?php echo date('H:i:s'); ?></div>
        </div>

        
        <ul class="menu">
            <li><a href="add_patient.php"><i class="fas fa-user-plus"></i> Añadir Paciente</a></li>
            <li><a href="add_doctor.php"><i class="fas fa-user-md"></i> Añadir Doctor</a></li>
            <li><a href="view_patients.php"><i class="fas fa-users"></i> Ver Pacientes</a></li>
            <li><a href="view_doctors.php"><i class="fas fa-user-md"></i> Ver Doctores</a></li>
            <li><a href="new_appointment.php"><i class="fas fa-calendar-plus"></i> Nueva Cita</a></li>
            <li><a href="view_appointment.php"><i class="fas fa-calendar-check"></i> Ver Citas</a></li>
        </ul>

        <div class="logout-btn">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
        </div>
    </div>

    <script>
        function updateTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('current-time').textContent = `Hora: ${hours}:${minutes}:${seconds}`;
        }

        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>
</html>


