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

    if (!empty($alumnoId) && !empty($newClass)) {
        // Verificar si el alumno ya está en la clase seleccionada
        $checkSql = "SELECT clase FROM alumnos WHERE id = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("i", $alumnoId);
        $checkStmt->execute();
        $checkStmt->bind_result($currentClass);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($currentClass === $newClass) {
            // Si el alumno ya está en la clase, redirigir con un mensaje de error
            header("Location: ../gestionarAlumnos.php?message=Este%20alumno%20ya%20está%20en%20la%20clase%20seleccionada&type=error");
        } else {
            // Mover el alumno a la nueva clase
            $updateSql = "UPDATE alumnos SET clase = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("si", $newClass, $alumnoId);

            if ($updateStmt->execute()) {
                // Redirigir con un mensaje de éxito
                header("Location: ../gestionarAlumnos.php?message=Alumno%20movido%20satisfactoriamente&type=success");
            } else {
                // Redirigir con un mensaje de error si la actualización falla
                header("Location: ../gestionarAlumnos.php?message=Error%20al%20mover%20el%20alumno&type=error");
            }

            $updateStmt->close();
        }
    } else {
        // Redirigir con un mensaje de error si faltan datos
        header("Location: ../gestionarAlumnos.php?message=Todos%20los%20campos%20son%20obligatorios&type=error");
    }
}

$conn->close();
?>
