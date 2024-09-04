<?php
    include("conexion.php");

    $contrasena = $_POST['contrasena'];
    $nombre = $_POST['nombre'];
    $celular = $_POST['celular'];
    
    
    if ($nombre && $celular ) {
        $query="INSERT INTO administradores (CONTRASENA, NOMBRE, CELULAR) VALUES ('$contrasena', '$nombre', '$celular' )";
        $result=mysqli_query($link,$query) or die("error en la consulta de productos");

        setcookie('message', "Usuario editado correctamente!", time() + 5, '/');
        header("Location: ../index.php");
    } else {

        setcookie('message', "La informacion nombre, celular,  son requeridas!", time() + 5, '/');
        header("Location: ../index.php");
    }

?>