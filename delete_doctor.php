<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM doctores WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: view_doctors.php");
        exit();
    } else {
        echo "Error al eliminar el doctor.";
    }
} else {
    echo "ID de doctor no proporcionado.";
}
?>
