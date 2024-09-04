<?php
    include("conexion.php");

    $query="SELECT * FROM colaboradores";
    $colaboradores=mysqli_query($link,$query) or die("error en la consulta de productos");
        
    return $colaboradores;
?>
