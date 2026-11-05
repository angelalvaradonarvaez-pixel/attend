
<?php
// --------------------------------------------------------------------------------
//        SE FORMATEAN  (A MAYUSCULAS)  LAS VARIABLES
// ----------------------------------------------------------------------------------
$usuario = htmlspecialchars($_REQUEST['text_usuario']);
$usuario = strtoupper($usuario);
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
    $stmt = $pdo->prepare('SELECT usuario, nombre FROM public."usuarios" WHERE usuario = :usuario');
    $stmt->execute(['usuario' => $usuario]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = 'Database connection or query failed: ' . $e->getMessage();
}

// -------------------------------------------------------------------------------------------
if ($row) {  // REGISTRO EXISTE
    $url = 'editar_usuario.php?usuario=' . $row['usuario']."&mensaje=Registro encontrado.";
    $url .= '&color=green';
    echo "<SCRIPT>window.location='$url';</SCRIPT>";
} else {  // REGISTRO NO EXISTE
    $url = 'prepara_busqueda_usuario.php?mensaje=El usuario ' . $usuario . '   ! no fue encontrado. !';;
    $url .= '&color=red';
    echo "<SCRIPT>window.location='$url';</SCRIPT>";
}
?>




