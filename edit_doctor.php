<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM doctores WHERE id='$id'";
    $result = $conn->query($sql);
    $doctor = $result->fetch_assoc();
}

if (isset($_POST['update_doctor'])) {
    $nombre = $_POST['doctorName'];
    $especialidad = $_POST['specialty'];

    $sql = "UPDATE doctores SET nombre='$nombre', especialidad='$especialidad' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: view_doctors.php");
        exit();
    } else {
        $error = "Error al actualizar el doctor.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Doctor</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Editar Doctor</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <label for="doctorName">Nombre del Doctor:</label>
            <input type="text" id="doctorName" name="doctorName" value="<?php echo $doctor['nombre']; ?>" required><br>
            <label for="specialty">Especialidad:</label>
            <input type="text" id="specialty" name="specialty" value="<?php echo $doctor['especialidad']; ?>" required><br>
            <button type="submit" name="update_doctor">Actualizar Doctor</button>
        </form>
        <a href="view_doctors.php">Volver a la lista de Doctores</a>
    </div>
</body>
</html>

