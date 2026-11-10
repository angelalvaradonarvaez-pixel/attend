
<?php
// --------------------------------------------------------------------------------
//        SE FORMATEAN  (A MAYUSCULAS)  LAS VARIABLES
// ----------------------------------------------------------------------------------
$iddep = htmlspecialchars($_REQUEST['text_iddep']);
$iddep = strtoupper($iddep);

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
    $stmt = $pdo->prepare('SELECT iddep, desdep FROM public."Departamentos" WHERE iddep = :iddep');
    $stmt->execute(['iddep' => $iddep]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = 'Database connection or query failed: ' . $e->getMessage();
}

// -------------------------------------------------------------------------------------------
if ($row) {  // REGISTRO EXISTE
    $url = 'editar_departamento.php?iddep=' . $row['iddep']."&mensaje=Registro encontrado.";
    $url .= '&color=green';
    echo "<SCRIPT>window.location='$url';</SCRIPT>";
} else {  // REGISTRO NO EXISTE
    $url = 'prepara_busqueda_departamento.php?mensaje=El departamento ' . $iddep . '   ! no fue encontrado. !';;
    $url .= '&color=green';
    echo "<SCRIPT>window.location='$url';</SCRIPT>";
}
?>




