<?php
    include("conexion.php");

    $id_colaborador = isset($_GET['id_colaborador']) ? $_GET['id_colaborador'] : null;
    $password_colaborador = isset($_GET['password_colaborador']) ? $_GET['password_colaborador'] : null;
    $id_administrador = isset($_GET['id_administrador']) ? $_GET['id_administrador'] : null;
    $password_administrador = isset($_GET['password_administrador']) ? $_GET['password_administrador'] : null;

    if ($id_colaborador) {
        $query = "SELECT * FROM colaboradores WHERE ID = $id_colaborador";
        $result = mysqli_query($link, $query) or die("Error en la consulta de colaborador");

        if (mysqli_num_rows($result) > 0) {
            $usuario = mysqli_fetch_array($result);

            if ($usuario['Contrasena'] != $password_colaborador) { // Corregido aquí
                setcookie('message', "Contraseña incorrecta!", time() + 5, '/');
                header("Location: ../index.php");
                exit(); // Asegúrate de usar exit después de header
            } else {
                $idE = $usuario['ID'];
                setcookie('idE', $idE, time() + 3600, '/');
                header("Location: ../colaborador.php?idE=$idE");
                exit(); // Asegúrate de usar exit después de header
            }
        } else {
            setcookie('message', "Usuario no encontrado!", time() + 5, '/');
            header("Location: ../index.php");
            exit(); // Asegúrate de usar exit después de header
        }
    } else if ($id_administrador) {
        $query = "SELECT * FROM administradores WHERE ID = $id_administrador";
        $result = mysqli_query($link, $query) or die("Error en la consulta de administrador");

        if (mysqli_num_rows($result) > 0) {
            $usuario = mysqli_fetch_array($result);

            if ($usuario['CONTRASENA'] != $password_administrador) {
                setcookie('message', "Contraseña incorrecta!", time() + 5, '/');
                header("Location: ../index.php");
                exit(); // Asegúrate de usar exit después de header
            } else {
                $idP = $usuario['ID'];
                setcookie('idP', $idP, time() + 3600, '/');
                header("Location: ../vista.php");
                exit(); // Asegúrate de usar exit después de header
            }
        } else {
            setcookie('message', "Usuario no encontrado!", time() + 5, '/');
            header("Location: ../index.php");
            exit(); // Asegúrate de usar exit después de header
        }
    }
?>
