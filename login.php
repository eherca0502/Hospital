<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['loginUser'];
    $password = $_POST['loginPassword'];

    // Consultar el usuario en la base de datos
    $sql = "SELECT * FROM usuarios WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Sesión iniciada correctamente";
        
    } else {
        echo "Usuario o contraseña incorrectos";
    }

    $conn->close();
}
?>
