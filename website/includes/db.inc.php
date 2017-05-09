<?php 

$host = 'localhost';
$dbname = 'aufision';
$user = 'root';
$pass = '';

try {

    $pdo = new PDO("mysql:host=$host;dbname=$dbname",
        $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES "utf8"');

} catch (PDOException $e) {

    $error = 'Can\'t connect to database: ' . $e->getMessage();
    include 'error.php';
    exit();

}