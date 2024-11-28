<?php
// moveAlumno.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $alumnoId = trim($_POST['alumnoSelect']);
    $newClass = trim($_POST['newClass']);
    $profesorId = $_SESSION['user_id'];

    if (!empty($alumnoId) && !empty($newClass)) {
        $checkSql = "SELECT clase FROM alumnos WHERE id = ? AND profesor_id = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("ii", $alumnoId, $profesorId);
        $checkStmt->execute();
        $checkStmt->bind_result($currentClass);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($currentClass === $newClass) {
            header("Location: ../gestionarAlumnos.php?message=Este%20alumno%20ya%20está%20en%20la%20clase%20seleccionada&type=error");
        } else {
            $updateSql = "UPDATE alumnos SET clase = ? WHERE id = ? AND profesor_id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("sii", $newClass, $alumnoId, $profesorId);

            if ($updateStmt->execute()) {
                header("Location: ../gestionarAlumnos.php?message=Alumno%20movido%20satisfactoriamente&type=success");
            } else {
                header("Location: ../gestionarAlumnos.php?message=Error%20al%20mover%20el%20alumno&type=error");
            }
            $updateStmt->close();
        }
    } else {
        header("Location: ../gestionarAlumnos.php?message=Todos%20los%20campos%20son%20obligatorios&type=error");
    }
}

$conn->close();
?>
