
<?php
// --------------------------------------------------------------------------------
//        SE FORMATEAN  (A MAYUSCULAS)  LAS VARIABLES
// ----------------------------------------------------------------------------------
$iddep = htmlspecialchars($_REQUEST['text_iddep']);
$desdep = htmlspecialchars($_REQUEST['text_desdep']);

$iddep = strtoupper($iddep);
$desdep = strtoupper($desdep);
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
    $targetId = $iddep;
    // Prepare the SQL query using LIMIT 1 for performance
    $sql = 'SELECT 1 FROM public."Departamentos" WHERE "iddep" = :iddep LIMIT 1';
    $stmt = $pdo->prepare($sql);
    // Execute the query securely with the parameter binding
    $stmt->execute(['iddep' => $targetId]);
    // fetchColumn() returns the first column of the next row, or false if no rows exist
    $exists = $stmt->fetchColumn() !== false;
} catch (\PDOException $e) {
    echo 'Connection or query failed: ' . $e->getMessage();
}
// -------------------------------------------------------------------------------------------
if ($exists)  // REGISTRO YA EXISTE
{
    $url = 'agregar_departamento.php?mensaje=El departamento ' . $iddep . ' ! ya existe  !';;
    $url .= '&color=red';
    $url .= '&text_iddep=' . $_REQUEST['text_iddep'];
    $url .= '&text_desdep=' . $_REQUEST['text_desdep'];
    echo "<SCRIPT>window.location='$url';</SCRIPT>";
} else {
    // ---------------------------------------------------
    //                      SE GRABA EL REGISTRO
    // ----------------------------------------------------
    try {
        //   LA CONEXIÓN YA ESTÁ ESTABLECIDA ARRIBA, SOLO SE PREPARA LA CONSULTA
        $sql = 'INSERT INTO public."Departamentos" (iddep, desdep) VALUES (:iddep, :desdep)';
        // Prepare and execute statement
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':iddep' => $iddep,
            ':desdep' => $desdep
        ]);
        $url = 'departamentos.php?mensaje=El departamento ' . $iddep . '  ! se ha registrado correctamente !';;
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




