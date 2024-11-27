<?php
// enviarPracticas.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

include './includes/dbConnection.php';
<<<<<<< HEAD

// Obtener el ID del profesor de la sesión
$profesorId = $_SESSION['user_id'];
=======
>>>>>>> a6ead99ffbf64f87010048c87d2ccee2fe4f7c47
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Alumnos a Prácticas - FEPLA CRM</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <script src="./assets/js/popups.js" defer></script> <!-- Usando el archivo popups.js -->
    <style>
        /* Estilos para la vista gráfica */
        .view-table {
            width: 100%;
            border-collapse: collapse;
        }
        .view-table th, .view-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .view-table th {
            background-color: #f4f4f4;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <?php include './includes/header.php'; ?>

    <div class="container">
        <h1>Enviar Alumnos a Prácticas</h1>

        <!-- Formulario para enviar alumno a prácticas -->
        <form action="./functions/enviarAlumnoPracticas.php" method="POST">
            <label for="alumnoId">Seleccionar Alumno:</label>
            <select id="alumnoId" name="alumnoId" required>
                <?php
<<<<<<< HEAD
                // Mostrar solo los alumnos del profesor en sesión
                $result = $conn->query("SELECT id, nombre, apellido1, apellido2 
                                        FROM alumnos 
                                        WHERE profesor_id = $profesorId AND nombre IS NOT NULL AND nombre != ''");
=======
                // Asegurarte de que se están mostrando los alumnos correctos
                $result = $conn->query("SELECT id, nombre, apellido1, apellido2 FROM alumnos WHERE nombre IS NOT NULL AND nombre != ''");
>>>>>>> a6ead99ffbf64f87010048c87d2ccee2fe4f7c47
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($row['id']) . "'>" .
                        htmlspecialchars($row['nombre'] . ' ' . $row['apellido1'] . ' ' . $row['apellido2']) . "</option>";
                }
                ?>
            </select>

            <label for="empresaId">Seleccionar Empresa:</label>
            <select id="empresaId" name="empresaId" required>
                <?php
<<<<<<< HEAD
                // Mostrar todas las empresas (globales)
=======
>>>>>>> a6ead99ffbf64f87010048c87d2ccee2fe4f7c47
                $result = $conn->query("SELECT id, nombre FROM empresas");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['nombre']) . "</option>";
                }
                ?>
            </select>

            <button type="submit" name="action" value="enviar" class="button">Enviar a Prácticas</button>
        </form>

        <!-- Vista Gráfica para Modificar o Eliminar -->
        <h2>Alumnos en Prácticas</h2>
        <table class="view-table">
            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>Empresa</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
<<<<<<< HEAD
                // Mostrar asignaciones solo del profesor en sesión
                $result = $conn->query("SELECT asignaciones.id AS asignacion_id, 
                                               alumnos.nombre, alumnos.apellido1, alumnos.apellido2, 
                                               empresas.id AS empresa_id, empresas.nombre AS empresa_nombre
                                        FROM asignaciones
                                        JOIN alumnos ON asignaciones.alumno_id = alumnos.id
                                        JOIN empresas ON asignaciones.empresa_id = empresas.id
                                        WHERE asignaciones.profesor_id = $profesorId");
=======
                // Consulta para obtener las asignaciones de los alumnos a las empresas
                $result = $conn->query("SELECT asignaciones.id AS asignacion_id, alumnos.nombre, alumnos.apellido1, alumnos.apellido2, empresas.id AS empresa_id, empresas.nombre AS empresa_nombre
                                        FROM asignaciones
                                        JOIN alumnos ON asignaciones.alumno_id = alumnos.id
                                        JOIN empresas ON asignaciones.empresa_id = empresas.id");
>>>>>>> a6ead99ffbf64f87010048c87d2ccee2fe4f7c47
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['nombre'] . ' ' . $row['apellido1'] . ' ' . $row['apellido2']) . "</td>";
                    echo "<td>";
                    echo "<form action='./functions/modificarAlumnoPracticas.php' method='POST' class='inline-form'>";
                    echo "<input type='hidden' name='asignacionId' value='" . htmlspecialchars($row['asignacion_id']) . "'>";
                    echo "<select name='empresaId'>";
<<<<<<< HEAD

=======
                    
>>>>>>> a6ead99ffbf64f87010048c87d2ccee2fe4f7c47
                    // Generar las opciones de empresa
                    $empresas = $conn->query("SELECT id, nombre FROM empresas");
                    while ($empresa = $empresas->fetch_assoc()) {
                        $selected = ($empresa['id'] == $row['empresa_id']) ? "selected" : "";
                        echo "<option value='" . htmlspecialchars($empresa['id']) . "' $selected>" . htmlspecialchars($empresa['nombre']) . "</option>";
                    }
<<<<<<< HEAD

=======
                    
>>>>>>> a6ead99ffbf64f87010048c87d2ccee2fe4f7c47
                    echo "</select>";
                    echo "<button type='submit' class='button'>Modificar</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "<td class='actions'>";
                    echo "<form action='./functions/eliminarAlumnoPracticas.php' method='POST' class='inline-form'>";
                    echo "<input type='hidden' name='asignacionId' value='" . htmlspecialchars($row['asignacion_id']) . "'>";
                    echo "<button type='submit' class='button'>Eliminar</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
