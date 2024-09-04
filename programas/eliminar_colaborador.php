<?php
    include("conexion.php");
    
    $deleteId = $_POST['id'];

    // Realizar la consulta SQL para eliminar al colaborador
    $query = "DELETE FROM colaboradores WHERE ID = $deleteId";
    $result = mysqli_query($link, $query) or die("error en la consulta de productos");

    setcookie('message', "Usuario eliminado correctamente!", time() + 5, '/');
    header("Location: ../vista.php");
?>