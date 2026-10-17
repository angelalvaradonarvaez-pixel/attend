<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
if (isset($_REQUEST['registro'])) {
    $idsuc = $_REQUEST['registro'];
} else {
    echo "Error, No se recibio el parametro 'registro'";
}

?>
<html><head>  
 <meta http-equiv="content-type" content="text/html;charset=utf-8">
  <title>Borrando sucursal...</title>  
</head>
<body><br>
<?php

$host = 'localhost';
$db = 'Ejemplos';
$user = 'postgres';
$pass = 'harryh';

try {
    // Establish a secure PDO connection to PostgreSQL
    $dsn = "pgsql:host=$host;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Assuming $pdo is your active PDO connection

$sql = 'DELETE FROM public."Sucursales" WHERE Idsuc = :idsuc';
$stmt = $pdo->prepare($sql);

if ($stmt->execute(['idsuc' => $idsuc])) {
    // echo "Record deleted successfully.";
    echo " <script>document.location.href= './sucursales.php'; </script>";
} else {
    echo 'Error deleting record.';
}

?>
</body>