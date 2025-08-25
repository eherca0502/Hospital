<?php
// Inicia la sesión y conecta a la base de datos
session_start();
include 'db.php';

// Verificar si se ha seleccionado un doctor
$doctorSeleccionado = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctorSeleccionado = $_POST['doctor'];
}

// Obtener la lista de doctores
$doctores = $conn->query("SELECT id, nombre, especialidad FROM doctores");

// Si hay un doctor seleccionado, obtener sus citas
$citas = [];
if ($doctorSeleccionado) {
    $sql = "SELECT citas.id, pacientes.nombre AS paciente, doctores.nombre AS doctor, citas.fecha, citas.hora 
            FROM citas 
            JOIN pacientes ON citas.id_paciente = pacientes.id
            JOIN doctores ON citas.id_doctor = doctores.id
            WHERE citas.id_doctor = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $doctorSeleccionado);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($cita = $resultado->fetch_assoc()) {
        $citas[] = $cita;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Citas</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Agregar el enlace a Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e8f4f8; /* Light Blue for hospital environment */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
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
            margin-bottom: 20px;
        }

        label {
            margin-bottom: 5px;
            color: #00796b; /* Teal */
            font-weight: bold;
        }

        select {
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff; /* Blue */
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #e6e6e6;
        }

        .actions a {
            color: #007bff; /* Blue */
            text-decoration: none;
            margin: 0 5px;
            font-size: 18px;
        }

        .actions a:hover {
            color: #0056b3; /* Darker Blue */
        }

        .back-btn {
            text-align: center;
            margin-top: 20px;
        }

        .back-btn a {
            text-decoration: none;
            color: #007bff; /* Blue */
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
        <h2>Ver Citas</h2>

        <!-- Formulario para seleccionar doctor -->
        <form method="POST" action="">
            <label for="doctor">Seleccionar Doctor:</label>
            <select name="doctor" required>
                <option value="">--Seleccionar Doctor--</option>
                <?php while ($doctor = $doctores->fetch_assoc()) { ?>
                    <option value="<?php echo htmlspecialchars($doctor['id']); ?>" 
                        <?php echo ($doctorSeleccionado == $doctor['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($doctor['nombre']) . " (" . htmlspecialchars($doctor['especialidad']) . ")"; ?>
                    </option>
                <?php } ?>
            </select>
            <button type="submit">Ver Citas</button>
        </form>

        <!-- Mostrar citas si hay un doctor seleccionado -->
        <?php if ($doctorSeleccionado && count($citas) > 0) { ?>
            <h3>Citas del Doctor</h3>
            <table>
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Doctor</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($citas as $cita) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cita['paciente']); ?></td>
                            <td><?php echo htmlspecialchars($cita['doctor']); ?></td>
                            <td><?php echo htmlspecialchars($cita['fecha']); ?></td>
                            <td><?php echo htmlspecialchars($cita['hora']); ?></td>
                            <td class="actions">
                                <a href="edit_appointment.php?id=<?php echo htmlspecialchars($cita['id']); ?>">
                                    <i class="fas fa-pencil-alt"></i> <!-- Ícono de lápiz -->
                                </a>
                                <a href="delete_appointment.php?id=<?php echo htmlspecialchars($cita['id']); ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta cita?');">
                                    <i class="fas fa-trash-alt"></i> <!-- Ícono de basurero -->
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } elseif ($doctorSeleccionado) { ?>
            <p>No hay citas para este doctor.</p>
        <?php } ?>

        <!-- Botón para volver al menú -->
        <div class="back-btn">
            <a href="menu.php">Volver al Menú</a>
        </div>

        <!-- Notificación emergente -->
        <?php if (!empty($success)): ?>
            <div class="notification success">
                <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                <?php echo htmlspecialchars($success); ?>
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
