<?php
    include("programas/obtener_colaborador.php");
    

    $id = $usuario['ID'];
    $nombre = $usuario['NOMBRE'];    
    $celular = $usuario['CELULAR'];
    $correo = $usuario['CORREO'];    
    $rh = $usuario['RH'];
    $CC = $usuario['CC'];
    $cargo = $usuario['CARGO'];
    $estado_actual = $usuario['ESTADO_ACTUAL'];
    $fecha_nacimiento = $usuario['FECHA_NACIMIENTO'];
    $fecha_ingreso = $usuario['FECHA_INGRESO'];
    $fecha_retiro = $usuario['FECHA_RETIRO'];
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colaborador <?php echo $nombre; ?></title>
    <link rel="stylesheet" href="css/colaborador.css">
    <link rel="stylesheet" href="css/general.css">
</head>
<body>
    <main class="main">
        <header class="header">
        <h1 style="font-size: 36px;"><strong>Sima Elevadores SAS</strong></h1>

            <ul class="header__options">
                <li class="header__option">
                    <h2><?php echo $nombre; ?></h2>
                    <img src="assets/icons/user.png" alt="user" width="48px" height="48px">
                </li>
                <a class="btn header__option header__option--exit" href="/proyecto">
                    <h3>Salir</h3>
                    <img src="assets/icons/exit.png" alt="exit" width="32px" height="32px">
                </a>
            </ul>
        </header>   

       
        <div class="vista">
    <div class="vista__header">
        <div class="vista__brand">
            <div class="vista__brand-info" style="font-size: 1.5em;">
                <h1><strong>Sima Elevadores SAS</strong></h1>
                <h2><strong>Perfil</strong></h2>
            </div>
            <figure class="vista__brand-image" style="border: 2px solid gray; box-shadow: 2px 2px 5px #888888;">
    <img src="assets/images/1f.jpg" alt="brand" width="150px" height="150px">
</figure>

        </div>
        <div class="vista__data" style="font-size: 1.2em; display: grid; grid-template-columns: 1fr 1fr;">
            <div>
                <p><strong>Nombre:</strong> <?php echo $nombre; ?></p>
                <p><strong>Celular:</strong> <?php echo $celular; ?></p>
                <p><strong>Correo:</strong> <?php echo $correo; ?></p>
                <p><strong>RH:</strong> <?php echo $rh; ?></p>
                <p><strong>CC:</strong> <?php echo $CC; ?></p>
            </div>
            <div>
                <p><strong>Cargo:</strong> <?php echo $cargo; ?></p>
                <p><strong>Estado Actual:</strong> <?php echo $estado_actual; ?></p>
                <p><strong>Fecha Nacimiento:</strong> <?php echo $fecha_nacimiento; ?></p>
                <p><strong>Fecha Ingreso:</strong> <?php echo $fecha_ingreso; ?></p>
                <p><strong>Fecha Retiro:</strong> <?php echo $fecha_retiro; ?></p>
            </div>
        </div>
    </div>


            
          
           <div class="vista__table">
                <table>
                    <thead>
                        <tr>
                            <th>CERTIFICADOS</th>
                        </tr>   
                    </thead>
                    <tr>    
                        <td class='vista__table-administrador'>
                            <a class='btn' href='./desprendible.php?idE=<?php echo $row['ID']; ?>' target='_blank'>Desprendible Nómina</a>
                            
                            <a class='btn' href='./certificado.php?idE=<?php echo $row['ID']; ?>' target='_blank'>Certificado Laboral</a>
                        </td>
                    </tr>
                </table>
            </div>

     <div class="container_mt-5">
            <h2>Calcular de Vacaciones</h2>
        <form action="calcular_vacaciones.php" method="POST">
            <div class="mb-3">
                <label for="fecha_ingreso" class="form-label">Fecha de ingreso:</label>
                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso">
            </div>
            <button type="submit" class="btn btn-primary">Calcular</button>
        </form>
    </div>
 </div>


    </main>
</body>
</html>
