<?php
    $id = isset($_COOKIE['id']) ? $_COOKIE['id'] : null;
    $type = isset($_COOKIE['type']) ? $_COOKIE['type'] : null;

    if ($id) {
        setcookie('id', '', time() - 3600, '/');
    }
    if ($type) {
        setcookie('type', '', time() - 3600, '/');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/general.css">
    
</head>
<body>
    <main class="main">
        <div class="login">
            <h1>Sima <br>Elevadores S.A.S .</h1>
            <div class="buttons">
                <button class="btn" onclick="seleccionarcolaborador()" >Colaborador</button>
                <button class="btn" onclick="seleccionaradministrador()" >Admininstrador</button>
            </div>
            <form action="programas/ingresar.php" method="get" id="formulario_colaborador" onsubmit="return validar(this)">
                <div class="form-field">
                    <input type="text" name="id_colaborador" id="id_colaborador" placeholder="Ingresa ID">
                    <input type="password" name="password_colaborador" id="password_colaborador" placeholder="Contraseña">
                </div>
                <button class="btn">Ingresar</button>
            </form>
            <form action="programas/ingresar.php" method="get" id="formulario_administrador" onsubmit="return validar(this)">
                <div class="form-field">
                    <input type="text" name="id_administrador" id="id_administrador" placeholder="Ingresa ID">
                    <input type="password" name="password_administrador" id="password_administrador" placeholder="Contraseña">
                </div>
                <button class="btn" type="submit">Ingresar</button>
                <button class="btn btn--add" type="button" onclick="openPopup('add_administrador')">Nuevo</button>
            </form>
        </div>
    </main>

    

    <div class="overlay" id="add_administrador">
        <div class="popup">
            <div class="popup__head">
                <h2>Agregar administrador</h2>
                <span class="popup__head-close"><img src="assets/icons/reject.png" alt="exit" width="32px" height="32px" onclick="closePopup('add_administrador')"></span>
            </div>
            <div class="popup__body">
                <form action="programas/crear_administrador.php" method="POST" class="form">
                    <div class="form__field">
                        <label for="contrasena">Contraseña:</label>
                        <input type="password" name="contrasena" id="contrasena" placeholder="Ingrese contraseña del administrador...">
                    </div>
                    <div class="form__field">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" placeholder="Ingrese nombre del administrador...">
                    </div>
                    <div class="form__field">
                        <label for="celular">Celular:</label>
                        <input type="text" name="celular" id="celular" placeholder="Ingrese celular del administrador...">
                    </div>
                    
                </form>
            </div>
            <div class="popup__footer">
                <button class="btn btn--add" onclick="submitForm('#add_administrador .form')">Aceptar</button>
                <button class="btn btn--del" onclick="closePopup('add_administrador')">Cancelar</button>
            </div>
        </div>
    </div>


    <script>
        const message = "<?php 
            $message = isset($_COOKIE['message']) ? $_COOKIE['message'] : '';
            echo $message;
        ?>";

        if (message) {
            setTimeout(() => {
                alert(message);
            }, 100);
        }

        function seleccionarcolaborador() {
            document.getElementById("formulario_colaborador").style.display = "flex";
            document.getElementById("formulario_administrador").style.display = "none";
        }

        function seleccionaradministrador() {
            document.getElementById("formulario_colaborador").style.display = "none";
            document.getElementById("formulario_administrador").style.display = "flex";    
        }

        function closePopup(id) {
            document.getElementById(id).style.display = 'none';
        }

        function openPopup(id) {
            document.getElementById(id).style.display = 'flex';
        }

        function submitForm(formSelector) {
            document.querySelector(formSelector).submit();
        }

        function validar(formulario) {
            if(formulario.id_colaborador.value == '' || formulario.id_administrador.value == '') {
                alert('Sr Usuario debe ingresar el codigo del colaborador o administrador para continuar');
                formulario.id_colaborador.focus();
                return false;
            } else if (formulario.password_administrador.value == '') {
                alert('Sr Usuario debe ingresar la contraseña para continuar');
                formulario.password_administrador.focus();
                return false;
            }

            return true;
        }
        </script>
        <script>
        document.getElementById('descargar_pdf').addEventListener('click', function() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'generar_pdf.php', true);
            xhr.responseType = 'blob';
        
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var blob = new Blob([xhr.response], { type: 'application/pdf' });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'nombre_archivo.pdf';
                    link.click();
                }
            };
        
            xhr.send();
        });
        </script>
    </script>
        <script>
        document.getElementById('descargar_pdf').addEventListener('click', function() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'generar_pdf.php', true);
            xhr.responseType = 'blob';
        
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var blob = new Blob([xhr.response], { type: 'application/pdf' });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'nombre_archivo.pdf';
                    link.click();
                }
            };
        
            xhr.send();
        });
        </script>
</body>
</html>