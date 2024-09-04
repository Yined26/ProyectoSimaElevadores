<?php
include(__DIR__ . "/conexion.php");

$pdo = conectarBaseDeDatos("elevadores");
try {
    // Consulta para obtener todos los colaboradores
    $query = "SELECT id, nombre, cc FROM colaboradores";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $elevadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Variable para almacenar el ID del colaborador seleccionado
    $selectedColaboradorId = null;

    // Si se ha enviado un ID de colaborador desde el formulario, lo asignamos
    if (isset($_POST['colaborador_id'])) {
        $selectedColaboradorId = $_POST['colaborador_id'];
    }

    // Obtener los datos del colaborador seleccionado
    $querySelected = "SELECT nombre, cc, estado_actual, fecha_ingreso, fecha_retiro, cargo FROM colaboradores WHERE id = :id";
    $stmtSelected = $pdo->prepare($querySelected);
    $stmtSelected->bindParam(':id', $selectedColaboradorId, PDO::PARAM_INT);
    $stmtSelected->execute();
    $selectedColaborador = $stmtSelected->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Manejo de errores de la base de datos
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de Trabajo</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <style>
        .certificate {
            text-align: justify; /* Justificar el texto */
            font-family: 'Times New Roman', Times, serif;
            border: 2px solid #000;
            padding: 30px;
            margin-top: 20px;
        }
        .header-logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .header-logo img {
            max-width: 150px;
        }
        .signature {
            margin-top: 50px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <div class="header-logo">
                    <img src="C:/xamp/htdocs/proyecto/assets/images/1F.JPG" alt="1F.JPG">
                </div>
                <h1 class="mb-4 text-center">Sima Elevadores SAS</h1>

                <?php if (!empty($selectedColaborador)): ?>
                    <div class="certificate">
                        <p><strong>CERTIFICA:</strong></p>
                        <p>Que <strong><?php echo htmlspecialchars($selectedColaborador['nombre']); ?></strong>, identificado(a) con cédula de ciudadanía número <strong><?php echo htmlspecialchars($selectedColaborador['cc']); ?></strong>, trabaja con Sima Elevadores SAS desde el <strong><?php echo date('d \d\e ') . getSpanishMonth(date('n', strtotime($selectedColaborador['fecha_ingreso']))) . date(' \d\e Y', strtotime($selectedColaborador['fecha_ingreso'])); ?></strong>, actualmente ocupando el cargo de <strong><?php echo htmlspecialchars($selectedColaborador['cargo']); ?></strong>.</p>

                        <?php
                        $estado = htmlspecialchars($selectedColaborador['estado_actual']);
                        if (strtolower($estado) === 'activo') {
                            echo "<p>Actualmente se encuentra trabajando con nosotros.</p>";
                        } else {
                            echo "<p>Trabajó con nosotros hasta el <strong>" . date('d \d\e ') . getSpanishMonth(date('n', strtotime($selectedColaborador['fecha_retiro']))) . date(' \d\e Y', strtotime($selectedColaborador['fecha_retiro'])) . "</strong>.</p>";
                        }
                        ?>
                        
                        <p>Se expide, a los <?php date_default_timezone_set('America/Bogota'); echo "Hora actual del servidor: " . date('Y-m-d H:i:s');
?>, a solicitud del interesado.</p>
                        <hr>
                        <div class="signature">
                            <p>__________________________</p>
                            <p>DIRECTOR(A) ADMINISTRATIVO(A) TALENTO HUMANO</p>
                        </div>
                    </div>
                <?php else: ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="form-group">
                            <label for="colaborador_id">Selecciona un colaborador:</label>
                            <select class="form-control" id="colaborador_id" name="colaborador_id">
                                <?php foreach ($elevadores as $elevador): ?>
                                    <option value="<?php echo htmlspecialchars($elevador['id']); ?>"><?php echo htmlspecialchars($elevador['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Generar Certificado</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col text-center">
                <form action="generar_pdf.php" method="post">
                    <input type="hidden" name="colaborador_id" value="<?php echo $selectedColaboradorId; ?>">
                    <button type="submit" class="btn btn-primary">Generar PDF</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
function getSpanishMonth($monthIndex) {
    $months = [
        1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    ];
    return $months[$monthIndex];
}
?>
