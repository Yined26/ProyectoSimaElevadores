<?php
// Define las constantes de conexión a la base de datos
define('DB_HOST', 'localhost'); // Dirección del servidor de base de datos
define('DB_USER', 'root');      // Nombre de usuario de MySQL
define('DB_PASS', '');          // Contraseña de MySQL
define('DB_NAME', 'elevadores');        // Nombre de la base de datos

function conectarBaseDeDatos()
{
    try {
        // Crea una conexión segura a la base de datos
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);

        // Habilita el modo de errores para las excepciones de PDO
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    } catch (PDOException $e) {
        // En caso de error, muestra un mensaje de error
        die("Error de conexión a la base de datos: " . $e->getMessage());
    }
 
}

 ?>