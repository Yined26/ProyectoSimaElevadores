<?php
include("conexion.php");

// Verifica que se haya enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Captura y escapa los datos del formulario
    $id = mysqli_real_escape_string($link, $_POST['id']);
    $nombre = mysqli_real_escape_string($link, $_POST['nombre']);
    $cc = mysqli_real_escape_string($link, $_POST['cc']);
    $celular = mysqli_real_escape_string($link, $_POST['celular']);
    $correo = mysqli_real_escape_string($link, $_POST['correo']);
    $rh = mysqli_real_escape_string($link, $_POST['rh']);
    $cargo = mysqli_real_escape_string($link, $_POST['cargo']);
    $fecha_ingreso = mysqli_real_escape_string($link, $_POST['fecha_ingreso']);
    $estado_actual = mysqli_real_escape_string($link, $_POST['estado_actual']);
    $fecha_nacimiento = mysqli_real_escape_string($link, $_POST['fecha_nacimiento']);

    // Verifica que los campos requeridos no estén vacíos
    if (!empty($nombre) && !empty($celular) && !empty($correo) && !empty($rh) && !empty($cargo) && !empty($fecha_ingreso) && !empty($estado_actual)) {
        // Actualiza los datos del colaborador utilizando parámetros seguros
        $query = "UPDATE colaboradores SET NOMBRE=?, CELULAR=?, CORREO=?, RH=?, CARGO=?, FECHA_INGRESO=?, ESTADO_ACTUAL=?, FECHA_NACIMIENTO=? WHERE ID=?";
        
        // Preparar la declaración
        $stmt = mysqli_prepare($link, $query);
        
        if ($stmt) {
            // Vincular parámetros y ejecutar la consulta
            mysqli_stmt_bind_param($stmt, "ssssssssi", $nombre, $celular, $correo, $rh, $cargo, $fecha_ingreso, $estado_actual, $fecha_nacimiento, $id);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                setcookie('message', "Usuario editado correctamente!", time() + 5, '/');
                header("Location: ../index.php");
                exit();
            } else {
                setcookie('message', "Error en la consulta: " . mysqli_stmt_error($stmt), time() + 5, '/');
                header("Location: ../index.php");
                exit();
            }
        } else {
            setcookie('message', "Error en la preparación de la consulta: " . mysqli_error($link), time() + 5, '/');
            header("Location: ../index.php");
            exit();
        }
    } else {
        setcookie('message', "Todos los campos son requeridos!", time() + 5, '/');
        header("Location: ../index.php");
        exit();
    }

    // Cerrar la declaración y la conexión
    mysqli_stmt_close($stmt);
}

// Cerrar la conexión
mysqli_close($link);
?>
