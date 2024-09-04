<?php
// Iniciar el búfer de salida
ob_start();
include(__DIR__ . "/conexion.php");

$pdo = conectarBaseDeDatos("elevadores");

$selectedColaboradorId = $_POST['colaborador_id'];

try {
    // Obtener los datos del colaborador seleccionado
    $querySelected = "SELECT nombre, cc FROM colaboradores WHERE id = :id";
    $stmtSelected = $pdo->prepare($querySelected);
    $stmtSelected->bindParam(':id', $selectedColaboradorId, PDO::PARAM_INT);
    $stmtSelected->execute();
    $selectedColaborador = $stmtSelected->fetch(PDO::FETCH_ASSOC);

    // Obtener el detalle de pagos del colaborador seleccionado
    $queryPagos = "SELECT Salario_Base, bonificacion, Descuentos_Salud, Descuentos_Pension, Descuentos_Incapacidad, Periodo_Pago FROM comprobante WHERE ID_Colaborador = :id";
    $stmtPagos = $pdo->prepare($queryPagos);
    $stmtPagos->bindParam(':id', $selectedColaboradorId, PDO::PARAM_INT);
    $stmtPagos->execute();
    $desprendible = $stmtPagos->fetch(PDO::FETCH_ASSOC);

    // Calcular Neto a Pagar
    $salarioBase = $desprendible['Salario_Base'];
    $bonificacion = $desprendible['bonificacion'];
    $descuentosSalud = $desprendible['Descuentos_Salud'];
    $descuentosPension = $desprendible['Descuentos_Pension'];
    $descuentosIncapacidad = $desprendible['Descuentos_Incapacidad'];

    $netoPagar = ($salarioBase + $bonificacion) - ($descuentosSalud + $descuentosPension + $descuentosIncapacidad);

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
    <title>Desprendible de Pago</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .header-logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .header-logo img {
            max-width: 150px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #f4f4f4;
        }
        .table .income {
            text-align: left;
        }
        .table .deductions {
            text-align: right;
        }
        h1, h2 {
            text-align: center;
        }
        .total-row {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-logo">
            <img src="C:/xamp/htdocs/proyecto/proyecto/assets/images/1F.jpg" alt="logo">
        </div>
        <h1>Desprendible de Pago</h1>
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($selectedColaborador['nombre']); ?></p>
        <p><strong>CC:</strong> <?php echo htmlspecialchars($selectedColaborador['cc']); ?></p>
        <p><strong>Periodo de Pago:</strong> <?php echo htmlspecialchars($desprendible['Periodo_Pago']); ?></p>
        <p><strong>Fecha de emisión:</strong> <?php echo date('d-m-Y'); ?></p>
        <hr>
        <h2>Detalle de Pagos</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Concepto</th>
                    <th>Ingreso (COP)</th>
                    <th>Deducción (COP)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Salario Base</td>
                    <td class="income"><?php echo number_format($salarioBase, 0, ',', '.'); ?></td>
                    <td class="deductions"></td>
                </tr>
                <tr>
                    <td>Bonificación</td>
                    <td class="income"><?php echo number_format($bonificacion, 0, ',', '.'); ?></td>
                    <td class="deductions"></td>
                </tr>
                <tr>
                    <td>Descuentos Salud</td>
                    <td class="income"></td>
                    <td class="deductions"><?php echo number_format($descuentosSalud, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td>Descuentos Pensión</td>
                    <td class="income"></td>
                    <td class="deductions"><?php echo number_format($descuentosPension, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td>Descuentos Incapacidad</td>
                    <td class="income"></td>
                    <td class="deductions"><?php echo number_format($descuentosIncapacidad, 0, ',', '.'); ?></td>
                </tr>
                <tr class="total-row">
                    <td>Total Neto a Pagar</td>
                    <td class="income"></td>
                    <td class="deductions"><?php echo number_format($netoPagar, 0, ',', '.'); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$html = ob_get_clean();

require(__DIR__ . '/vendor/autoload.php');
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4');
$dompdf->render();
$dompdf->stream("desprendible_pago.pdf", array('Attachment' => true));
?>
