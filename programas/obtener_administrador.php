<?php
    include("conexion.php");
    
    if (isset($_COOKIE['idP'])) {

        $id = $_COOKIE['idP'];        
        $query="SELECT * FROM administradores WHERE ID=$id";
        $result=mysqli_query($link,$query) or die("error en la consulta de productos");

        if(mysqli_num_rows($result)>0) {
            $usuario = mysqli_fetch_array($result);   

            return $usuario;
        } else {
            setcookie('message', "Usuario no encontrado!", time() + 5, '/');
            header("Location: ../index.php");
        }
    }

?>
