
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
    $sql = 'UPDATE public."usuarios" SET nombre = :nombre, contra = :contra, tipo = :tipo WHERE usuario = :usuario';
    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute([
        ':usuario' => $usuario,
        ':nombre' => $nombre,
        ':contra' => $contra,
        ':tipo' => $lst_tipo
    ]);

    // Call the function
    if ($success) {
        $url = 'usuarios.php?mensaje=el usuario ' . $usuario . '   ! se ha actualizado correctamente !';;
        $url .= '&color=green';
        echo "<SCRIPT>window.location='$url';</SCRIPT>";
    } else {
        $url = 'usuarios.php?mensaje=el usuario ' . $usuario . '   ! no se ha podido actualizar !';;
        $url .= '&color=red';
        echo "<SCRIPT>window.location='$url';</SCRIPT>";
    }
} catch (\PDOException $e) {
    echo 'Connection or query failed: ' . $e->getMessage();
}

?>




