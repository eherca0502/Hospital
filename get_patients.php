<?php
include 'db.php';

$sql = "SELECT * FROM pacientes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Salida de cada fila
    while($row = $result->fetch_assoc()) {
        echo "Nombre: " . $row["nombre"]. " - Fecha de Ingreso: " . $row["fecha_ingreso"]. " - Fecha de Alta: " . $row["fecha_alta"]. "<br>";
    }
} else {
    echo "0 pacientes";
}

$conn->close();
?>
