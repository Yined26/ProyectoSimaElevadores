<?php
// Iniciar el búfer de salida
ob_start();
include(__DIR__ . "/conexion.php");

$pdo = conectarBaseDeDatos("elevadores");
try {
    // Consulta para obtener los datos del colaborador
    $query = "
        SELECT nombre, cc, fecha_ingreso, fecha_retiro, estado_actual, cargo
        FROM colaboradores
        WHERE id = :id
    ";

    // Obtenemos el ID del colaborador seleccionado desde el formulario
    $colaboradorId = isset($_POST['colaborador_id']) ? $_POST['colaborador_id'] : null;

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $colaboradorId, PDO::PARAM_INT);
    $stmt->execute();
    $colaborador = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Manejo de errores de la base de datos
    echo "Error: " . $e->getMessage();
}

function getSpanishMonth($monthIndex) {
    $months = [
        1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    ];
    return $months[$monthIndex];
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
            font-family: 'Times New Roman', Times, serif;
            border: 2px solid #000;
            padding: 30px;
            margin-top: 20px;
            text-align: justify;
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
        .signature-line {
            margin-top: 50px;
            border-top: 1px solid #000;
            width: 200px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <div class="header-logo">
                    <img src="C:/xamp/htdocs/proyecto/assets/images/1F.JPG" alt="Logo">
                </div>
                <h1 class="mb-4 text-center">Sima Elevadores SAS</h1>
                <?php if ($colaborador): ?>
                    <div class="certificate">
                        <p><strong>CERTIFICA:</strong></p>
                        <p>Que <strong><?php echo htmlspecialchars($colaborador['nombre']); ?></strong>, identificado(a) con cédula de ciudadanía número <strong><?php echo htmlspecialchars($colaborador['cc']); ?></strong>, trabaja con la Sima Elevadores SAS desde el <strong><?php echo date('d \d\e ') . getSpanishMonth(date('n')) . date(' \d\e Y', strtotime($colaborador['fecha_ingreso'])); ?></strong>, actualmente ocupando el cargo de <strong><?php echo htmlspecialchars($colaborador['cargo']); ?></strong>.</p>
                        <?php if (strtolower($colaborador['estado_actual']) === 'activo'): ?>
                            <p>Actualmente se encuentra vinculado(a) a nuestra empresa.</p>
                        <?php else: ?>
                            <p>Trabajó con nosotros hasta el <strong><?php echo date('d \d\e ') . getSpanishMonth(date('n', strtotime($colaborador['fecha_retiro']))) . date(' \d\e Y', strtotime($colaborador['fecha_retiro'])); ?></strong>.</p>
                        <?php endif; ?>
                        <p>Se expide en Bogotá, a los <?php echo date('d'); ?> días del mes de <?php echo getSpanishMonth(date('n')); ?> de <?php echo date('Y'); ?>, a solicitud del interesado.</p>
                        <br><br>
                        <div class="signature">
                            <p>__________________________</p>
                            <p>DIRECTOR(A) ADMINISTRATIVO(A) TALENTO HUMANO</p>
                        </div>
                    </div>
                <?php else: ?>
                    <p>No se encontraron datos del colaborador.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$html = ob_get_clean();

require (__DIR__ . '/vendor/autoload.php');
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$options = $dompdf->getOptions();
$options->set(['isRemoteEnabled' => true]);
$dompdf->setOptions($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4');
$dompdf->render();
$dompdf->stream("certificado_trabajo.pdf", ['Attachment' => true]);
?>
