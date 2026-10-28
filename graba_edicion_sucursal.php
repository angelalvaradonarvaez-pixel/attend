
<?php
// --------------------------------------------------------------------------------
//        SE FORMATEAN  (A MAYUSCULAS)  LAS VARIABLES
// ----------------------------------------------------------------------------------
$idsuc = htmlspecialchars($_REQUEST['text_idsuc']);
$dessuc = htmlspecialchars($_REQUEST['text_dessuc']);

$idsuc = strtoupper($idsuc);
$dessuc = strtoupper($dessuc);

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
    $sql = 'UPDATE public."Sucursales" SET dessuc = :dessuc WHERE idsuc = :idsuc';
    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute([
        ':idsuc' => $idsuc,
        ':dessuc' => $dessuc
    ]);

    // Call the function
    if ($success) {
        $url = 'sucursales.php?mensaje=la sucursal ' . $idsuc . '   ! se ha actualizado correctamente !';;
        $url .= '&color=green';
        echo "<SCRIPT>window.location='$url';</SCRIPT>";
    } else {
        $url = 'sucursales.php?mensaje=la sucursal ' . $idsuc . '   ! no se ha podido actualizar !';;
        $url .= '&color=red';
        echo "<SCRIPT>window.location='$url';</SCRIPT>";
    }
} catch (\PDOException $e) {
    echo 'Connection or query failed: ' . $e->getMessage();
}

?>




