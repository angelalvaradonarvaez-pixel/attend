
<?php
// --------------------------------------------------------------------------------
//        SE FORMATEAN  (A MAYUSCULAS)  LAS VARIABLES
// ----------------------------------------------------------------------------------
$usuario = htmlspecialchars($_REQUEST['text_usuario']);
$nombre = htmlspecialchars($_REQUEST['text_nombre']);
$contra = htmlspecialchars($_REQUEST['text_contra']);
$lst_tipo = htmlspecialchars($_REQUEST['lsttipo'] ?? '');

$usuario = strtoupper($usuario);
$nombre = strtoupper($nombre);
//$contra = $contra;
//$lst_tipo = $lst_tipo;
// --------------------------------------------------------------------------------------------------------------------
//            SE VALIDA QUE EL DEPARTAMENTO NO ESTE REPETIDO
// ---------------------------------------------------------------------------------------------------------------------
// Database configuration
$host = 'localhost';
$db = 'Ejemplos';
$user = 'postgres';
$pass = 'harryh';
$port = '5432';

$dsn = "pgsql:host=$host;port=$port;dbname=$db";

try {
    // Create a PDO instance with error mode set to exception
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    // The value you want to look up in the 'idsuc' column
    $targetId = $usuario;
    // Prepare the SQL query using LIMIT 1 for performance
    $sql = 'SELECT 1 FROM public."usuarios" WHERE "usuario" = :usuario LIMIT 1';
    $stmt = $pdo->prepare($sql);
    // Execute the query securely with the parameter binding
    $stmt->execute(['usuario' => $targetId]);
    // fetchColumn() returns the first column of the next row, or false if no rows exist
    $exists = $stmt->fetchColumn() !== false;
} catch (\PDOException $e) {
    echo 'Connection or query failed: ' . $e->getMessage();
}
// -------------------------------------------------------------------------------------------
if ($exists)  // REGISTRO YA EXISTE
{
    $url = 'agregar_usuario.php?mensaje=el usuario ' . $usuario . ' ! ya existe  !';;
    $url .= '&color=red';
    $url .= '&text_usuario=' . $_REQUEST['text_usuario'];
    $url .= '&text_nombre=' . $_REQUEST['text_nombre'];
    $url .= '&text_contra=' . $_REQUEST['text_contra'];
    $url .= '&lsttipo=' . $_REQUEST['lsttipo'];
    echo "<SCRIPT>window.location='$url';</SCRIPT>";
} else {
    // ---------------------------------------------------
    //                      SE GRABA EL REGISTRO
    // ----------------------------------------------------
    try {
        //   LA CONEXIÓN YA ESTÁ ESTABLECIDA ARRIBA, SOLO SE PREPARA LA CONSULTA
        $sql = 'INSERT INTO public."usuarios" ("usuario", "nombre", "contra", "tipo") VALUES (:usuario, :nombre, :contra, :tipo)';
        // Prepare and execute statement
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':usuario' => $usuario,
            ':nombre' => $nombre,
            ':contra' => $contra,
            ':tipo' => $lst_tipo
        ]);
        $url = 'usuarios.php?mensaje=el usuario ' . $usuario . '  ! se ha registrado correctamente !';;
        $url .= '&color=green';
        echo "<SCRIPT>window.location='$url';</SCRIPT>";
    } catch (PDOException $e) {
        // Check for duplicate primary key error (SQLSTATE 23505)
        if ($e->getCode() === '23505') {
            $message = 'Error: A record with this ID already exists.';
        } else {
            $message = 'Database error: ' . $e->getMessage();
        }
        $messageType = 'error';
    }
}
?>




