<?php
include("conexion.php");

// Agregar var_dump para imprimir los datos del formulario
var_dump($_POST);


$contrasena = $_POST['contrasena'];
$nombre = $_POST['nombre'];
$cc = $_POST['cc'];
$celular = $_POST['celular'];
$Correo = $_POST['correo'];
$rh = $_POST['rh'];
$cargo = $_POST['cargo'];
$estado_actual = $_POST['estado_actual'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$fecha_ingreso = $_POST['fecha_ingreso'];
$fecha_retiro = $_POST['fecha_retiro'];

if (!empty($contrasena) && !empty($nombre) && !empty($cc) && !empty($celular) && !empty($Correo) && !empty($rh) && !empty($cargo) && !empty($estado_actual) && !empty($fecha_nacimiento) && !empty($fecha_ingreso) && !empty($fecha_retiro)) {
    $query = "INSERT INTO colaboradores (contrasena, nombre, cc, celular, Correo, rh, cargo, estado_actual, fecha_nacimiento, fecha_ingreso, fecha_retiro) VALUES ('$contrasena','$nombre','$cc', '$celular', '$Correo', '$rh', '$cargo', '$estado_actual', '$fecha_nacimiento', '$fecha_ingreso', '$fecha_retiro')";
    $result = mysqli_query($link, $query) or die("error en la consulta de productos");

    setcookie('message', "Usuario editado correctamente!", time() + 5, '/');
    header("Location: ../index.php");
} else {
    setcookie('message', "La información ,es requerida!", time() + 5, '/');
    header("Location: ../index.php");
}
?>

