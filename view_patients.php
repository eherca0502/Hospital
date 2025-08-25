<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
include 'db.php';

$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

$sql = "SELECT * FROM pacientes WHERE nombre LIKE ?";
$stmt = $conn->prepare($sql);
$search_param = "%" . $search . "%";
$stmt->bind_param("s", $search_param);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Pacientes</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e8f4f8; /* Light Blue */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            color: #004d40; /* Dark Teal */
            text-align: center;
            margin-bottom: 20px;
        }

        /* Estilos para el formulario de búsqueda */
        .search-form {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .search-form input[type="text"] {
            width: 250px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-right: 10px;
        }

        .search-form button {
            padding: 10px 15px;
            background-color: #007bff; /* Blue */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-form button:hover {
            background-color: #0056b3; /* Darker Blue */
        }

        /* Estilos para la tabla de pacientes */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #ffffff; /* White */
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #007bff; /* Blue */
            color: white;
        }

        table tr:hover {
            background-color: #f1f1f1; /* Light Grey */
        }

        /* Estilos para las etiquetas de alta y no alta */
        .no-alta {
            display: inline-block;
            padding: 5px 10px;
            background-color: #f44336; /* Rojo */
            color: white;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }

        .alta {
            display: inline-block;
            padding: 5px 10px;
            background-color: #4CAF50; /* Verde */
            color: white;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }

        /* Estilos para las acciones */
        .actions a {
            color: #007bff;
            text-decoration: none;
            margin: 0 5px;
            font-size: 18px;
        }

        .actions a:hover {
            color: #0056b3;
        }

        /* Botón de volver al menú */
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
        <h2>Lista de Pacientes</h2>

        <!-- Formulario de búsqueda -->
        <form method="POST" action="" class="search-form">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Buscar por nombre...">
            <button type="submit">Buscar</button>
        </form>

        <!-- Tabla de pacientes -->
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha de Ingreso</th>
                    <th>Fecha de Alta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($row['fecha_ingreso']); ?></td>
                            <td>
                                <?php if ($row['fecha_alta']): ?>
                                    <span class="alta"><?php echo htmlspecialchars($row['fecha_alta']); ?></span>
                                <?php else: ?>
                                    <span class="no-alta">No dado de alta</span>
                                <?php endif; ?>
                            </td>
                            <td class="actions">
                                <a href="edit_patient.php?id=<?php echo htmlspecialchars($row['id']); ?>" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                <a href="delete_patient.php?id=<?php echo htmlspecialchars($row['id']); ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar este paciente?');" title="Eliminar"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No se encontraron pacientes.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Botón para volver al menú -->
        <div class="back-btn">
            <a href="menu.php">Volver al Menú</a>
        </div>
    </div>
</body>
</html>



