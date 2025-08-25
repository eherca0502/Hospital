<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM pacientes WHERE id='$id'";
    $result = $conn->query($sql);
    $patient = $result->fetch_assoc();
}

if (isset($_POST['update_patient'])) {
    $nombre = $_POST['patientName'];
    $fecha_ingreso = $_POST['admissionDate'];
    $fecha_alta = $_POST['dischargeDate'] ? $_POST['dischargeDate'] : NULL; // Asignar NULL si no se ingresa fecha de alta

    $sql = "UPDATE pacientes SET nombre='$nombre', fecha_ingreso='$fecha_ingreso', fecha_alta='$fecha_alta' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: view_patients.php");
        exit();
    } else {
        $error = "Error al actualizar el paciente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Paciente</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Editar Paciente</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <label for="patientName">Nombre del Paciente:</label>
            <input type="text" id="patientName" name="patientName" value="<?php echo htmlspecialchars($patient['nombre']); ?>" required><br>
            <label for="admissionDate">Fecha de Ingreso:</label>
            <input type="date" id="admissionDate" name="admissionDate" value="<?php echo htmlspecialchars($patient['fecha_ingreso']); ?>" required><br>
            <label for="dischargeDate">Fecha de Alta (opcional):</label>
            <input type="date" id="dischargeDate" name="dischargeDate" value="<?php echo htmlspecialchars($patient['fecha_alta']); ?>"><br>
            <button type="submit" name="update_patient">Actualizar Paciente</button>
        </form>
        <a href="view_patients.php">Volver a la lista de Pacientes</a>
    </div>
</body>
</html>

