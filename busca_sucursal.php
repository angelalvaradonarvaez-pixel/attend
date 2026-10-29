
<?php
// --------------------------------------------------------------------------------
//        SE FORMATEAN  (A MAYUSCULAS)  LAS VARIABLES
// ----------------------------------------------------------------------------------
$idsuc = htmlspecialchars($_REQUEST['text_idsuc']);

$idsuc = strtoupper($idsuc);
// --------------------------------------------------------
// Database configuration
$host = 'localhost';
$dbname = 'Ejemplos';
$user = 'postgres';
$password = 'harryh';

$row = null;
$error = null;

try {
    // Connect to PostgreSQL using PDO
    $dsn = "pgsql:host=$host;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Prepare and execute the query safely using a named parameter
    $stmt = $pdo->prepare('SELECT idsuc, dessuc FROM public."Sucursales" WHERE idsuc = :idsuc');
    $stmt->execute(['idsuc' => $idsuc]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = 'Database connection or query failed: ' . $e->getMessage();
}

// -------------------------------------------------------------------------------------------
if ($row) {  // REGISTRO EXISTE
    $url = 'editar_sucursal.php?idsuc=' . $row['idsuc']."&mensaje=Registro encontrado.";
    $url .= '&color=green';
    echo "<SCRIPT>window.location='$url';</SCRIPT>";
} else {  // REGISTRO NO EXISTE
    $url = 'prepara_busqueda_sucursal.php?mensaje=En la sucursal ' . $idsuc . '   ! no fue encontrada. !';;
    $url .= '&color=green';
    echo "<SCRIPT>window.location='$url';</SCRIPT>";
}
?>




