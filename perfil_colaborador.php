<?php
// Incluir el archivo que contiene la función para calcular los días de vacaciones
require_once 'calcular_vacaciones.php';
include(__DIR__ . "/conexion.php");

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID del colaborador desde el formulario
    $selectedColaboradorId = $_POST['colaborador_id'];

    // Consultar datos del colaborador
    try {
        $query = "SELECT nombre, fecha_ingreso FROM colaboradores WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $selectedColaboradorId, PDO::PARAM_INT);
        $stmt->execute();
        $colaborador = $stmt->fetch(PDO::FETCH_ASSOC);

        // Calcular los días de vacaciones
        $diasVacaciones = calcularDiasVacaciones($colaborador['fecha_ingreso']);
    } catch (PDOException $e) {
        // Manejo de errores de la base de datos
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Colaborador</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5 mb-4">Perfil del Colaborador</h1>

        <div class="row">
            <div class="col-md-6">
                <?php if (isset($colaborador)): ?>
                    <h2><?php echo htmlspecialchars($colaborador['nombre']); ?></h2>
                    <p>Fecha de Ingreso: <?php echo htmlspecialchars($colaborador['fecha_ingreso']); ?></p>
                    <p>Días de vacaciones acumulados: <?php echo isset($diasVacaciones) ? $diasVacaciones : 'No calculados'; ?></p>
                <?php else: ?>
                    <p>Selecciona un colaborador para calcular los días de vacaciones.</p>
                <?php endif; ?>

                <!-- Formulario para seleccionar un colaborador -->
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="form-group">
                        <label for="colaborador_id">Selecciona un colaborador:</label>
                        <select class="form-control" id="colaborador_id" name="colaborador_id" required>
                            <?php foreach ($colaboradores as $colaborador): ?>
                                <option value="<?php echo htmlspecialchars($colaborador['id']); ?>"><?php echo htmlspecialchars($colaborador['nombre']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Calcular Vacaciones</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap (JS) al final del archivo para mejorar el rendimiento -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
