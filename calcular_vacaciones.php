<?php
include('conexion.php'); // Incluye la conexión a la base de datos

// Verifica si se ha enviado el formulario para solicitar vacaciones
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_colaborador'])) {
    // Obtener datos del formulario
    $id_colaborador = $_POST['id_colaborador'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    // Convertir fechas en objetos DateTime
    $fecha_inicio_dt = new DateTime($fecha_inicio);
    $fecha_fin_dt = new DateTime($fecha_fin);
    $fecha_actual_dt = new DateTime();

    // Calcular el número de días solicitados
    $dias_solicitados = $fecha_inicio_dt->diff($fecha_fin_dt)->days + 1;

    // Consultar la fecha de ingreso del colaborador
    $query = "SELECT fecha_ingreso FROM colaboradores WHERE ID = $id_colaborador";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $fecha_ingreso = $row['fecha_ingreso'];
        $fecha_ingreso_dt = new DateTime($fecha_ingreso);
        $meses_trabajados = $fecha_ingreso_dt->diff($fecha_actual_dt)->m + ($fecha_ingreso_dt->diff($fecha_actual_dt)->y * 12);

        // Calcular el número de días de vacaciones a los que tiene derecho
        $dias_vacaciones = round($meses_trabajados * 15 / 12); // Proporción por mes

        // Mostrar los días de vacaciones a los que tiene derecho el trabajador
        echo "<div class='container mt-5'>";
        echo "<h2>Días de Vacaciones:</h2>";
        echo "<p>El colaborador tiene derecho a $dias_vacaciones días hábiles de vacaciones.</p>";
        echo "</div>";

        // Consultar el número de días de vacaciones acumuladas
        $query = "SELECT vacaciones_acumuladas FROM vacaciones WHERE ID_C = $id_colaborador";
        $result = mysqli_query($conn, $query);
        if ($row = mysqli_fetch_assoc($result)) {
            $dias_acumulados = $row['vacaciones_acumuladas'];

            // Verificar si hay suficiente saldo de vacaciones
            if ($dias_acumulados >= $dias_solicitados) {
                // Insertar solicitud en la base de datos
                $query = "INSERT INTO vacaciones (ID_C, fecha_inicio, fecha_fin, total_dias, Fecha_Solicitud, Estado)
                          VALUES ($id_colaborador, '$fecha_inicio', '$fecha_fin', $dias_solicitados, NOW(), 'Pendiente')";
                mysqli_query($conn, $query);

                // Actualizar días acumulados
                $dias_acumulados -= $dias_solicitados;
                $query = "UPDATE vacaciones SET vacaciones_acumuladas = $dias_acumulados WHERE ID_C = $id_colaborador";
                mysqli_query($conn, $query);

                // Enviar correo
                $to = 'daraque032@gmail.com';
                $subject = 'Solicitud de Vacaciones';
                $message = "El colaborador con ID $id_colaborador ha solicitado vacaciones.\n\n".
                           "Fecha de Inicio: $fecha_inicio\n".
                           "Fecha de Fin: $fecha_fin\n".
                           "Días Solicitados: $dias_solicitados\n".
                           "Días Acumulados: $dias_acumulados\n".
                           "Fecha de Solicitud: " . date('Y-m-d');

                $headers = "From: no-reply@tuempresa.com";
                mail($to, $subject, $message, $headers);

                echo "<div class='container mt-5'>";
                echo "<div class='alert alert-success' role='alert'>";
                echo "<h4 class='alert-heading'>Solicitud Enviada</h4>";
                echo "<p>Solicitud enviada exitosamente.</p>";
                echo "</div>";
                echo "</div>";
            } else {
                echo "<div class='container mt-5'>";
                echo "<div class='alert alert-danger' role='alert'>";
                echo "<h4 class='alert-heading'>Error</h4>";
                echo "<p>No tienes suficientes días de vacaciones acumulados.</p>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<div class='container mt-5'>";
            echo "<div class='alert alert-danger' role='alert'>";
            echo "<h4 class='alert-heading'>Error</h4>";
            echo "<p>No se encontraron días acumulados para el colaborador con ID $id_colaborador.</p>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<div class='container mt-5'>";
        echo "<div class='alert alert-danger' role='alert'>";
        echo "<h4 class='alert-heading'>Error</h4>";
        echo "<p>No se encontró la fecha de ingreso para el colaborador con ID $id_colaborador.</p>";
        echo "</div>";
        echo "</div>";
    }
} else {
    // Mostrar el formulario para solicitar vacaciones
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Calcular y Solicitar Vacaciones</title>
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h2>Solicitar Vacaciones</h2>
                        </div>
                        <div class="card-body">
                            <form action="calcular_vacaciones.php" method="POST">
                                <div class="form-group">
                                    <label for="id_colaborador">ID Colaborador:</label>
                                    <input type="number" class="form-control" id="id_colaborador" name="id_colaborador" required>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_inicio">Fecha de Inicio de Vacaciones:</label>
                                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_fin">Fecha de Fin de Vacaciones:</label>
                                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Solicitar Vacaciones</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>

    <?php
}
?>
