<?php
// viewLog.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

include './includes/dbConnection.php';

// Obtener el ID de la empresa para mostrar el log
$empresaId = $_GET['empresaSelectLog'];

// Recuperar los logs de la empresa
$sql = "SELECT accion, datos_anteriores, datos_nuevos, explicado_por, realizado_por, fecha FROM log_empresas WHERE empresa_id = ? ORDER BY fecha DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $empresaId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log de Empresa - FEPLA CRM</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <style>
        /* Estilo general para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        /* Estilo para las filas alternas */
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Resaltar las acciones */
        .creacion {
            background-color: #d4edda;
        }

        .modificacion {
            background-color: #fff3cd;
        }

        /* Estilo para los datos */
        .log-detail {
            font-size: 14px;
            margin-bottom: 8px;
        }

        .log-label {
            font-weight: bold;
        }

        /* Para las filas de los logs */
        .log-row {
            border-top: 2px solid #ddd;
        }

        /* Agrupar las acciones */
        .action-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .action-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        /* Estilo para las celdas de los emojis */
        .check-cell {
            text-align: center;
            font-size: 18px;
        }

        /* Estilo para los contenedores de datos */
        .data-columns {
            display: flex;
            justify-content: space-between;
        }

        .data-column {
            flex: 1;
            padding: 5px;
            font-size: 14px;
        }

        /* Dividir las columnas */
        .data-column span {
            display: block;
        }

        .action-column {
            width: 20%;
        }

        .data-column {
            width: 25%;
        }
    </style>
</head>

<body>
    <?php include './includes/header.php'; ?>

    <div class="container">
        <h1>Log de Empresa</h1>

        <table>
            <thead>
                <tr>
                    <th>Acción</th>
                    <th>Datos Anteriores</th>
                    <th>Datos Nuevos</th>
                    <th>Explicación</th>
                    <th>Realizado por</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()):
                    // Obtener el ID del profesor de la columna realizado_por
                    $profesorId = $row['realizado_por'];

                    // Consulta para obtener el nombre, apellido1 y apellido2 del profesor
                    $sql_profesor = "SELECT nombre, apellido1, apellido2 FROM profesores WHERE id = ?";
                    $stmt_profesor = $conn->prepare($sql_profesor);
                    $stmt_profesor->bind_param("i", $profesorId);
                    $stmt_profesor->execute();
                    $stmt_profesor->bind_result($profesor_nombre, $profesor_apellido1, $profesor_apellido2);
                    $stmt_profesor->fetch();
                    $stmt_profesor->close();

                    // Concatenar el nombre completo del profesor
                    if (empty($profesor_apellido2)) {
                        $profesor_completo = $profesor_nombre . ' ' . $profesor_apellido1;
                    } else {
                        $profesor_completo = $profesor_nombre . ' ' . $profesor_apellido1 . ' ' . $profesor_apellido2;
                    }

                    // Separar las acciones de la columna 'accion' en un array
                    $acciones = explode(", ", $row['accion']);

                    // Preparar los emojis de acuerdo a las acciones que contienen datos previos
                    $tick_icon = "✅";
                    $cross_icon = "❌";

                    // Asignar el emoji según si la acción está presente en los datos
                    $acciones_completadas = [
                        'Cambio de nombre' => in_array('Cambio de nombre', $acciones) ? $tick_icon : $cross_icon,
                        'Cambio de contacto principal' => in_array('Cambio de contacto principal', $acciones) ? $tick_icon : $cross_icon,
                        'Cambio de estado' => in_array('Cambio de estado', $acciones) ? $tick_icon : $cross_icon,
                        'Cambio de nombre oficial' => in_array('Cambio de nombre oficial', $acciones) ? $tick_icon : $cross_icon,
                        'Cambio de dirección sede central' => in_array('Cambio de dirección sede central', $acciones) ? $tick_icon : $cross_icon,
                        'Cambio de población' => in_array('Cambio de población', $acciones) ? $tick_icon : $cross_icon,
                        'Cambio de código postal' => in_array('Cambio de código postal', $acciones) ? $tick_icon : $cross_icon,
                        'Cambio de provincia' => in_array('Cambio de provincia', $acciones) ? $tick_icon : $cross_icon,
                        'Cambio de página web' => in_array('Cambio de página web', $acciones) ? $tick_icon : $cross_icon,
                        'Cambio de correo electrónico principal' => in_array('Cambio de correo electrónico principal', $acciones) ? $tick_icon : $cross_icon,
                        'Cambio de actividad principal' => in_array('Cambio de actividad principal', $acciones) ? $tick_icon : $cross_icon,
                        'Cambio de otras actividades' => in_array('Cambio de otras actividades', $acciones) ? $tick_icon : $cross_icon,
                        'Cambio de descripción breve' => in_array('Cambio de descripción breve', $acciones) ? $tick_icon : $cross_icon
                    ];


                ?>
                    <!-- Mostrar los datos agrupados -->
                    <tr class="log-row <?php echo (strpos($row['accion'], 'Cambio') !== false) ? 'modificacion' : 'creacion'; ?>">

                        <td class="action-column">
                            <div class="action-item">
                                <span>Cambio de nombre</span>
                                <span><?php echo $acciones_completadas['Cambio de nombre']; ?></span>
                            </div>
                            <div class="action-item">
                                <span>Cambio de contacto principal</span>
                                <span><?php echo $acciones_completadas['Cambio de contacto principal']; ?></span>
                            </div>
                            <div class="action-item">
                                <span>Cambio de estado</span>
                                <span><?php echo $acciones_completadas['Cambio de estado']; ?></span>
                            </div>
                            <div class="action-item">
                                <span>Cambio de nombre oficial</span>
                                <span><?php echo $acciones_completadas['Cambio de nombre oficial']; ?></span>
                            </div>
                            <div class="action-item">
                                <span>Cambio de dirección sede central</span>
                                <span><?php echo $acciones_completadas['Cambio de dirección sede central']; ?></span>
                            </div>
                            <div class="action-item">
                                <span>Cambio de población</span>
                                <span><?php echo $acciones_completadas['Cambio de población']; ?></span>
                            </div>
                            <div class="action-item">
                                <span>Cambio de código postal</span>
                                <span><?php echo $acciones_completadas['Cambio de código postal']; ?></span>
                            </div>
                            <div class="action-item">
                                <span>Cambio de provincia</span>
                                <span><?php echo $acciones_completadas['Cambio de provincia']; ?></span>
                            </div>
                            <div class="action-item">
                                <span>Cambio de página web</span>
                                <span><?php echo $acciones_completadas['Cambio de página web']; ?></span>
                            </div>
                            <div class="action-item">
                                <span>Cambio de correo electrónico principal</span>
                                <span><?php echo $acciones_completadas['Cambio de correo electrónico principal']; ?></span>
                            </div>
                            <div class="action-item">
                                <span>Cambio de actividad principal</span>
                                <span><?php echo $acciones_completadas['Cambio de actividad principal']; ?></span>
                            </div>
                            <div class="action-item">
                                <span>Cambio de otras actividades</span>
                                <span><?php echo $acciones_completadas['Cambio de otras actividades']; ?></span>
                            </div>
                            <div class="action-item">
                                <span>Cambio de descripción breve</span>
                                <span><?php echo $acciones_completadas['Cambio de descripción breve']; ?></span>
                            </div>
                        </td>

                        <td class="data-column">
    <?php
    // Obtener el campo 'datos_anteriores' como array
    $datos_anteriores = explode(", ", $row['datos_anteriores']);
    
    // Recorremos cada dato
    foreach ($datos_anteriores as $dato) {
        // Si el dato es un "Contacto: ID", buscamos el nombre del contacto
        if (preg_match('/Contacto:\s*(\d+)/', $dato, $matches)) {
            $contacto_id = $matches[1];
            // Realizar una consulta para obtener el nombre del contacto
            $sql_contacto = "SELECT nombre FROM contactos_empresas WHERE id = ?";
            $stmt_contacto = $conn->prepare($sql_contacto);
            $stmt_contacto->bind_param("i", $contacto_id);
            $stmt_contacto->execute();
            $stmt_contacto->bind_result($contacto_nombre);
            $stmt_contacto->fetch();
            $stmt_contacto->close();

            // Reemplazar el ID con el nombre del contacto
            $dato = str_replace("Contacto: $contacto_id", "Contacto: $contacto_nombre", $dato);
        }

        // Mostrar el dato en la tabla
        echo "<span>" . htmlspecialchars($dato) . "</span><br>";
    }
    ?>
</td>

<td class="data-column">
    <?php
    // Obtener el campo 'datos_nuevos' como array
    $datos_nuevos = explode(", ", $row['datos_nuevos']);
    
    // Recorremos cada dato
    foreach ($datos_nuevos as $dato) {
        // Si el dato es un "Contacto: ID", buscamos el nombre del contacto
        if (preg_match('/Contacto:\s*(\d+)/', $dato, $matches)) {
            $contacto_id = $matches[1];
            // Realizar una consulta para obtener el nombre del contacto
            $sql_contacto = "SELECT nombre FROM contactos_empresas WHERE id = ?";
            $stmt_contacto = $conn->prepare($sql_contacto);
            $stmt_contacto->bind_param("i", $contacto_id);
            $stmt_contacto->execute();
            $stmt_contacto->bind_result($contacto_nombre);
            $stmt_contacto->fetch();
            $stmt_contacto->close();

            // Reemplazar el ID con el nombre del contacto
            $dato = str_replace("Contacto: $contacto_id", "Contacto: $contacto_nombre", $dato);
        }

        // Mostrar el dato en la tabla
        echo "<span>" . htmlspecialchars($dato) . "</span><br>";
    }
    ?>
</td>


                        <td>
                            <div class="log-detail"><?php echo htmlspecialchars($row['explicado_por']); ?></div>
                        </td>
                        <td>
                            <div class="log-detail"><?php echo htmlspecialchars($profesor_completo); ?></div>
                        </td>
                        <td>
                            <div class="log-detail"><?php echo htmlspecialchars($row['fecha']); ?></div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
$stmt->close();
?>