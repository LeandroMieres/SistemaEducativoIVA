<?php
include("config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $contribuyente_id = $_GET['id'];

    $sql = "DELETE FROM contribuyentes WHERE Id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $contribuyente_id);

    if ($stmt->execute()) {
        header("Location: ContribuyentesListado.php");
    } else {
        echo "Error al eliminar el contribuyente: " . $stmt->error;
    }

    $stmt->close();
}

$conexion->close();
?>
