<?php
// manageAlumno.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include '../includes/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $alumnoId = trim($_POST['alumnoSelect']);

    if ($action === 'move') {
        $newClass = trim($_POST['newClass']);
        if (!empty($newClass)) {
            $sql = "UPDATE alumnos SET clase = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $newClass, $alumnoId);

            if ($stmt->execute()) {
                header("Location: ../gestionarAlumnos.php?message=Alumno%20movido%20exitosamente&type=success");
            } else {
                header("Location: ../gestionarAlumnos.php?message=Error%20al%20mover%20al%20alumno&type=error");
            }

            $stmt->close();
        } else {
            header("Location: ../gestionarAlumnos.php?message=La%20nueva%20clase%20es%20obligatoria&type=error");
        }
    } elseif ($action === 'delete') {
        $sql = "DELETE FROM alumnos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $alumnoId);

        if ($stmt->execute()) {
            header("Location: ../gestionarAlumnos.php?message=Alumno%20eliminado%20exitosamente&type=success");
        } else {
            header("Location: ../gestionarAlumnos.php?message=Error%20al%20eliminar%20al%20alumno&type=error");
        }

        $stmt->close();
    } elseif ($action === 'modify') {
        // Aquí puedes implementar la lógica para modificar los datos del alumno
        header("Location: ../gestionarAlumnos.php?message=Funcionalidad%20de%20modificación%20en%20desarrollo&type=info");
    }
}

$conn->close();
?>
