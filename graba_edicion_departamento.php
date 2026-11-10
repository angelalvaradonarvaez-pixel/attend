
<?php
// --------------------------------------------------------------------------------
//        SE FORMATEAN  (A MAYUSCULAS)  LAS VARIABLES
// ----------------------------------------------------------------------------------
$iddep = htmlspecialchars($_REQUEST['text_iddep']);
$desdep = htmlspecialchars($_REQUEST['text_desdep']);

$iddep = strtoupper($iddep);
//$desdep = strtoupper($desdep);

// Database configuration
$host = 'localhost';
$dbname = 'Ejemplos';
$user = 'postgres';
$password = 'harryh';


try {
    // Create a new PDO instance for PostgreSQL
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Variables for the update
    $success = false;
    $sql = 'UPDATE public."Departamentos" SET desdep = :desdep WHERE iddep = :iddep';
    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute([
        ':iddep' => $iddep,
        ':desdep' => $desdep
    ]);

    // Call the function
    if ($success) {
        $url = 'departamentos.php?mensaje=el departamento ' . $iddep . '   ! se ha actualizado correctamente !';;
        $url .= '&color=green';
        echo "<SCRIPT>window.location='$url';</SCRIPT>";
    } else {
        $url = 'departamentos.php?mensaje=el departamento ' . $iddep . '   ! no se ha podido actualizar !';;
        $url .= '&color=red';
        echo "<SCRIPT>window.location='$url';</SCRIPT>";
    }
} catch (\PDOException $e) {
    echo 'Connection or query failed: ' . $e->getMessage();
}

?>




