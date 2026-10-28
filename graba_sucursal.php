
<?php
// --------------------------------------------------------------------------------
//        SE FORMATEAN  (A MAYUSCULAS)  LAS VARIABLES
// ----------------------------------------------------------------------------------
$idsuc = htmlspecialchars($_REQUEST['text_idsuc']);
$dessuc = htmlspecialchars($_REQUEST['text_dessuc']);

$idsuc = strtoupper($idsuc);
$dessuc = strtoupper($dessuc);
// --------------------------------------------------------------------------------------------------------------------
//            SE VALIDA QUE LA SUCURSAL NO ESTE REPETIDA
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
    $targetId = $idsuc;
    // Prepare the SQL query using LIMIT 1 for performance
    $sql = 'SELECT 1 FROM public."Sucursales" WHERE "idsuc" = :idsuc LIMIT 1';
    $stmt = $pdo->prepare($sql);
    // Execute the query securely with the parameter binding
    $stmt->execute(['idsuc' => $targetId]);
    // fetchColumn() returns the first column of the next row, or false if no rows exist
    $exists = $stmt->fetchColumn() !== false;
} catch (\PDOException $e) {
    echo 'Connection or query failed: ' . $e->getMessage();
}
// -------------------------------------------------------------------------------------------
if ($exists)  // REGISTRO YA EXISTE
{
    $url = 'agregar_sucursal.php?mensaje=la sucursal ' . $idsuc . ' ! ya existe  !';;
    $url .= '&color=red';
    $url .= '&text_idsuc=' . $_REQUEST['text_idsuc'];
    $url .= '&text_dessuc=' . $_REQUEST['text_dessuc'];
    echo "<SCRIPT>window.location='$url';</SCRIPT>";
} else {
    // ---------------------------------------------------
    //                      SE GRABA EL REGISTRO
    // ----------------------------------------------------
    try {
        //   LA CONEXIÓN YA ESTÁ ESTABLECIDA ARRIBA, SOLO SE PREPARA LA CONSULTA
        $sql = 'INSERT INTO public."Sucursales" (idsuc, dessuc) VALUES (:idsuc, :dessuc)';
        // Prepare and execute statement
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':idsuc' => $idsuc,
            ':dessuc' => $dessuc
        ]);
        $url = 'sucursales.php?mensaje=la sucursal ' . $idsuc . '  ! se ha registrado correctamente !';;
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




