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
    // Redirigir a viewProfesores con un mensaje de éxito
    header("Location: viewProfesores.php?message=" . urlencode("Profesor eliminado exitosamente."));
} else {
    // Redirigir a viewProfesores con un mensaje de error
    header("Location: viewProfesores.php?error=" . urlencode("Error al eliminar el profesor: " . $stmt->error));
}

$stmt->close();
$conn->close();
?>
