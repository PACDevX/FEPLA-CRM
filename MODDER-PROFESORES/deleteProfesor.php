<?php
session_start();
if (!isset($_SESSION['is_root']) || $_SESSION['is_root'] !== true) {
    header("Location: ../index.html");
    exit;
}
include '../includes/dbConnection.php';

$profesorId = $_GET['id'];

$sql = "DELETE FROM profesores WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $profesorId);

if ($stmt->execute()) {
    echo "Profesor eliminado exitosamente.";
} else {
    echo "Error al eliminar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
