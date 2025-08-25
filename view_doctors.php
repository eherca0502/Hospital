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

$sql = "SELECT * FROM doctores WHERE especialidad LIKE ?";
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
    <title>Ver Doctores</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f9; /* Light Gray Blue */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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

        table tr:nth-child(even) {
            background-color: #f9f9f9; /* Light Gray */
        }

        .actions a {
            color: #007bff;
            text-decoration: none;
            margin: 0 5px;
            font-size: 18px;
        }

        .actions a:hover {
            color: #0056b3;
        }

        /* Estilos para el formulario de búsqueda */
        .search-form {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .search-form input[type="text"] {
            width: 200px;
            padding: 10px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .search-form button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .search-form button:hover {
            background-color: #0056b3;
        }

        /* Botón para volver al menú */
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
        <h2>Lista de Doctores</h2>

        <!-- Formulario de búsqueda -->
        <form method="POST" action="" class="search-form">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Buscar por especialidad...">
            <button type="submit">Buscar</button>
        </form>

        <!-- Tabla de doctores -->
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Especialidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($row['especialidad']); ?></td>
                            <td class="actions">
                                <a href="edit_doctor.php?id=<?php echo htmlspecialchars($row['id']); ?>" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                <a href="delete_doctor.php?id=<?php echo htmlspecialchars($row['id']); ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar este doctor?');" title="Eliminar"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No se encontraron doctores.</td>
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

