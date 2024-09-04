<?php
include(__DIR__ . "/conexion.php");

$pdo = conectarBaseDeDatos("elevadores");

try {
    // Consulta para obtener todos los colaboradores
    $query = "SELECT id, nombre, cc FROM colaboradores";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $colaboradores = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Variable para almacenar el ID del colaborador seleccionado
    $selectedColaboradorId = null;
    $selectedColaborador = null;

    // Si se ha enviado un ID de colaborador desde el formulario, lo asignamos
    if (isset($_POST['colaborador_id'])) {
        $selectedColaboradorId = $_POST['colaborador_id'];

        // Obtener los datos del colaborador seleccionado
        $querySelected = "SELECT nombre, cc FROM colaboradores WHERE id = :id";
        $stmtSelected = $pdo->prepare($querySelected);
        $stmtSelected->bindParam(':id', $selectedColaboradorId, PDO::PARAM_INT);
        $stmtSelected->execute();
        $selectedColaborador = $stmtSelected->fetch(PDO::FETCH_ASSOC);

        // Obtener el detalle de pagos del colaborador seleccionado
        $queryPagos = "SELECT * FROM colaboradores WHERE id = :id";
        $stmtPagos = $pdo->prepare($queryPagos);
        $stmtPagos->bindParam(':id', $selectedColaboradorId, PDO::PARAM_INT);
        $stmtPagos->execute();
        $desprendible = $stmtPagos->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    // Manejo de errores de la base de datos
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <div class="header-logo">
                    <img src="C:/xamp/htdocs/proyecto/assets/images/1F.JPG" alt="1F.JPG">
                </div>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desprendible de Pago</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <h1 class="mb-2">Sima Elevadores SAS</h1>

                <?php if (!empty($selectedColaborador)): ?>
                    <div class="certificate mb-5">
                        <p><strong>Comprobante de Pago</strong></p>
                        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($selectedColaborador['nombre']); ?></p>
                        <p><strong>CC:</strong> <?php echo htmlspecialchars($selectedColaborador['cc']); ?></p>
                        
                        <p>Se expide, a los <?php date_default_timezone_set('America/Bogota'); echo "Hora actual del servidor: " . date('Y-m-d H:i:s');
?>
</p>
                        <hr>
                        
                    </div>
                    <h2 class="mt-4">Detalle de Pagos</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Concepto</th>
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($desprendible as $pago): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($pago['salario_base']); ?></td>
                                    <td><?php echo htmlspecialchars($pago['bonificacion']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <div class="form-group">
                            <label for="colaborador_id">Selecciona un colaborador:</label>
                            <select class="form-control" id="colaborador_id" name="colaborador_id" required>
                                <?php foreach ($colaboradores as $colaborador): ?>
                                    <option value="<?php echo htmlspecialchars($colaborador['id']); ?>"><?php echo htmlspecialchars($colaborador['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Generar Certificado</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <?php if (!empty($selectedColaborador)): ?>
            <div class="row mt-5">
                <div class="col text-center">
                    <form action="generar1_pdf.php" method="post">
                        <input type="hidden" name="colaborador_id" value="<?php echo htmlspecialchars($selectedColaboradorId); ?>">
                        <button type="submit" class="btn btn-primary">Generar PDF</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
