<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elevadores";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$elevadores", $root, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
