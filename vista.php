<?php
    include("programas/obtener_administrador.php");
    include("programas/obtener_colaboradores.php");

    $id = $usuario['ID'];
    $nombre = $usuario['NOMBRE'];
    $celular = $usuario['CELULAR'];
    $correo = $usuario['CORREO'];
    $foto = $usuario['FOTO'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vista</title>
    <link rel="stylesheet" href="css/vista.css">
    <link rel="stylesheet" href="css/general.css">
    <style>
        .popup {
            width: 50%;
            margin: auto;
        }
    </style>
</head>
<body>
    <main class="main">
        <header class="header">
            <h1><strong>Sima Elevadores SAS</strong></h1>
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
        <aside class="aside">
            <ul class="aside__options">
                <li class="aside__option">
                    <button class="btn btn--add" onclick="openPopup('add_colaborador')" id="plus_colaborador">Agregar colaborador</button>
                </li>
            </ul>
        </aside>
            <div class="colaboradores">
                <div class="vista__table">
                    <table>
                        <thead>
                            <tr>
                                <th>CODIGO</th>
                                <th>NOMBRES</th>
                                <th>CELULAR</th>                            
                                <th>EDITAR</th>
                                <th>PERFIL</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($colaboradores) > 0) {
                                while($row = mysqli_fetch_array($colaboradores)) {
                                    echo "
                                    <tr>
                                        <td>$row[ID]</td>
                                        <td>$row[NOMBRE]</td>
                                        <td>$row[CELULAR]</td>
                                        <td><button class='btn btn--edit' onclick='editcolaborador({id: $row[ID], nombre: `$row[NOMBRE]`, celular: `$row[CELULAR]`, correo: `$row[CORREO]`, rh: `$row[RH]`, cargo: `$row[CARGO]`, estado_actual: `$row[ESTADO_ACTUAL]`, fecha_nacimiento: `$row[FECHA_NACIMIENTO]`, fecha_ingreso: `$row[FECHA_INGRESO]`, fecha_retiro: `$row[FECHA_RETIRO]`})'><img src='assets/icons/edit.png' alt='edit' width='16px'></button>
                                        </td>
                                        
                                        
                                        <td class='vista__table-acciones'>
                                            <a class='btn' href='./colaborador.php?idE=$row[ID]' target='_blank'><img src='assets/icons/view.png' alt='view' width='16px'></a>
                                            
                                            
                                        </td>
                                    </tr>
                                    ";
                                }
                            } else {
                                echo "<tr>NO SE ENCONTRARON REGISTROS</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </main>

    <!-- Formulario de Agregar Colaborador -->
    <div class="overlay" id="add_colaborador">
        <div class="popup">
            <div class="popup__head">
                <h2>Agregar colaborador</h2>
                <span class="popup__head-close"><img src="assets/icons/reject.png" alt="exit" width="32px" height="32px" onclick="closePopup('add_colaborador')"></span>
            </div>
            <div class="popup__body">
                <form action="programas/crear_colaborador.php" method="POST" class="form">
                    <div class="form__field">
                        <label for="contrasena">Contraseña:</label>
                        <input type="password" name="contrasena" id="contrasena" placeholder="Ingrese contraseña del administrador...">
                    </div>
                    <div class="form__field">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" placeholder="Ingrese nombre del colaborador...">
                    </div>
                    <div class="form__field">
                        <label for="cc">cc:</label>
                        <input type="text" name="cc" id="cc" placeholder="Ingrese cc del colaborador...">
                    </div>
                    <div class="form__field">
                        <label for="celular">Celular:</label>
                        <input type="text" name="celular" id="celular" placeholder="Ingrese celular del colaborador...">
                    </div>
                    <div class="form__field">
                        <label for="correo">Correo:</label>
                        <input type="text" name="correo" id="correo" placeholder="Ingrese correo del colaborador...">
                    </div>
                    <div class="form__field">
                        <label for="rh">RH:</label>
                        <input type="text" name="rh" id="rh" placeholder="Ingrese rh del colaborador...">
                    </div>
                    <div class="form__field">
                        <label for="cargo">Cargo:</label>
                        <input type="text" name="cargo" id="cargo" placeholder="Ingrese cargo del colaborador...">
                    </div>
                    <div class="form__field">
                        <label for="estado_actual">Estado Actual:</label>
                        <input type="text" name="estado_actual" id="estado_actual" placeholder="Ingrese estado actual del colaborador...">
                    </div>
                    <div class="form__field">
                        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento">
                    </div>           
                    <div class="form__field">
                        <label for="fecha_ingreso">Fecha de Ingreso:</label>
                        <input type="date" name="fecha_ingreso" id="fecha_ingreso">
                    </div>        
                    <div class="form__field">
                        <label for="fecha_retiro">Fecha de Retiro:</label>
                        <input type="date" name="fecha_retiro" id="fecha_retiro">
                    </div>
                    <div class="popup__footer">
                        <button class="btn btn--add" type="submit">Aceptar</button>
                        <button class="btn btn--del" type="button" onclick="closePopup('add_colaborador')">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Formulario de Editar Colaborador -->
    <div class="overlay" id="edit_colaborador">
        <div class="popup">
            <div class="popup__head">
                <h2>Editar colaborador</h2>
                <span class="popup__head-close"><img src="assets/icons/reject.png" alt="exit" width="32px" height="32px" onclick="closePopup('edit_colaborador')"></span>
            </div>
            <div class="popup__body">
                <form action="programas/editar_colaborador.php" method="POST" class="form">
                    <input type="hidden" name="id_colaborador" id="id_colaborador" readonly>
                    <div class="form__field">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="edit_nombre" placeholder="Ingrese nombre del colaborador...">
                    </div>
                    <div class="form__field">
                        <label for="cc">CC:</label>
                        <input type="text" name="cc" id="edit_cc" placeholder="Ingrese cc del colaborador...">
                    </div>
                    <div class="form__field">
                        <label for="celular">Celular:</label>
                        <input type="text" name="celular" id="edit_celular" placeholder="Ingrese celular del colaborador...">
                    </div>
                    <div class="form__field">
                        <label for="correo">Correo:</label>
                        <input type="text" name="correo" id="edit_correo" placeholder="Ingrese correo del colaborador...">
                    </div>
                    <div class="form__field">
                        <label for="rh">RH:</label>
                        <input type="text" name="rh" id="edit_rh" placeholder="Ingrese rh del colaborador...">
                    </div>
                    <div class="form__field">
                        <label for="cargo">Cargo:</label>
                        <input type="text" name="cargo" id="edit_cargo" placeholder="Ingrese cargo del colaborador...">
                    </div>
                    <div class="form__field">
                        <label for="estado_actual">Estado Actual:</label>
                        <input type="text" name="estado_actual" id="edit_estado_actual" placeholder="Ingrese estado actual del colaborador...">
                    </div>
                    <div class="form__field">
                        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                        <input type="date" name="fecha_nacimiento" id="edit_fecha_nacimiento">
                    </div>           
                    <div class="form__field">
                        <label for="fecha_ingreso">Fecha de Ingreso:</label>
                        <input type="date" name="fecha_ingreso" id="edit_fecha_ingreso">
                    </div>        
                    <div class="form__field">
                        <label for="fecha_retiro">Fecha de Retiro:</label>
                        <input type="date" name="fecha_retiro" id="edit_fecha_retiro">
                    </div>
                    <div class="popup__footer">
                        <button class="btn btn--add" type="submit">Aceptar</button>
                        <button class="btn btn--del" type="button" onclick="closePopup('edit_colaborador')">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Función para abrir los pop-ups
        function openPopup(id) {
            document.getElementById(id).style.display = 'block';
        }

        // Función para cerrar los pop-ups
        function closePopup(id) {
            document.getElementById(id).style.display = 'none';
        }

        // Función para editar colaborador
        function editcolaborador(colaborador) {
            document.getElementById('id_colaborador').value = colaborador.id;
            document.getElementById('edit_nombre').value = colaborador.nombre;
            document.getElementById('edit_cc').value = colaborador.cc;
            document.getElementById('edit_celular').value = colaborador.celular;
            document.getElementById('edit_correo').value = colaborador.correo;
            document.getElementById('edit_rh').value = colaborador.rh;
            document.getElementById('edit_cargo').value = colaborador.cargo;
            document.getElementById('edit_estado_actual').value = colaborador.estado_actual;
            document.getElementById('edit_fecha_nacimiento').value = colaborador.fecha_nacimiento;
            document.getElementById('edit_fecha_ingreso').value = colaborador.fecha_ingreso;
            document.getElementById('edit_fecha_retiro').value = colaborador.fecha_retiro;

            openPopup('edit_colaborador');
        }
    </script>
</body>
</html>
