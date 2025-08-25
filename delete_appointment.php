<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
include 'db.php';

// Verificar si se ha pasado el ID de la cita a eliminar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para eliminar la cita
    $sql = "DELETE FROM citas WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        // Redirigir de vuelta a la página de citas
        header("Location: view_appointment.php");
        exit();
    } else {
        echo "Error al eliminar la cita.";
    }
} else {
    echo "ID de cita no proporcionado.";
}
?>

