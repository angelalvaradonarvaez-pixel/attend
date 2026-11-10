<?php
require_once './funciones_generales.php';
// Initialize variables for feedback message
$text_usuario = '';
$text_nombre = '';
$text_contra = '';
$lst_tipo = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // SI LA PAGINA SE LLAMA A SI MISMA
    // Capture and sanitize inputs
    $text_usuario = htmlspecialchars(trim($_POST['text_usuario'] ?? ''));
    $text_nombre = htmlspecialchars(trim($_POST['text_nombre'] ?? ''));
    $text_contra = htmlspecialchars(trim($_POST['text_contra'] ?? ''));
    $lst_tipo = htmlspecialchars(trim($_POST['lsttipo'] ?? ''));
    // Validate fields
    $message = '';
    $message .= valida_campo($text_nombre, 'texto', 'Nombre', 'El');
    $message .= valida_campo($text_contra, 'password', 'Contraseña', 'La');
    $message .= valida_campo($lst_tipo, 'seleccionado', 'Tipo de usuario', 'El');

    if (empty($message)) {
        $url = 'graba_edicion_usuario.php?text_usuario=' . $_POST['text_usuario'];
        $url .= '&text_nombre=' . $_POST['text_nombre'];
        $url .= '&text_contra=' . $_POST['text_contra'];
        $url .= '&lsttipo=' . $_POST['lsttipo'];
        echo "<SCRIPT>window.location='$url';</SCRIPT>";
    } else {
        $text_usuario = strtoupper(trim($_REQUEST['text_usuario']));
        $text_nombre = trim($_REQUEST['text_nombre']);
        $text_contra = $_REQUEST['text_contra'];
        $lst_tipo = $_REQUEST['lsttipo'] ?? '';
    }
} else {  // SI LA PAGINA SE LLAMA DESDE OTRA PAGINA
    $usuario = strtoupper(trim($_GET['usuario'] ?? ''));
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
        $stmt = $pdo->prepare('SELECT usuario, nombre, contra, tipo FROM public."usuarios" WHERE usuario = :usuario');
        $stmt->execute(['usuario' => $usuario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = 'Database connection or query failed: ' . $e->getMessage();
    }

    // -------------------------------------------------------------------------------------------
    if ($row) {
        $text_usuario = strtoupper(trim($row['usuario']));
        $text_nombre = trim($row['nombre']);
        $text_contra = $row['contra'];
        $lst_tipo = $row['tipo'];
    } else {  // REGISTRO NO EXISTE
        $url = 'usuarios.php?mensaje=En el usuario ' . $usuario . ' ! hay inconsitencia de datos, llamar al encargado de sistemas. !';;
        $url .= '&color=green';
        echo "<SCRIPT>window.location='$url';</SCRIPT>";
    }

    if (isset($_REQUEST['mensaje'])) {
        $message = $_REQUEST['mensaje'];
    } else {
        $message = '';
    }
}
// --------------------------------------------------------

?>
<!DOCTYPE html>
<html lang="en">
   <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de asistencia</title>
    <script type="text/javascript" src="./js/funciones.js"></script>
    <link rel="stylesheet" href="./css/style_captura.css">
    <!-- Import Victorian-style serif font -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=IM+Fell+English&display=swap" rel="stylesheet"> 
    <!-- Include FontAwesome for the eye icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">    
  </head>

  <body>
    <h1>Editar usuario</h1>
    <div class="steampunk-ledger">
        <form name='fsucursal' method="POST" action=''>               
         
            <div class="form-group">
                <label for="text_usuario">Usuario</label>
                 <!-- Standard text field -->
                <input type="text" id="text_usuario" name="text_usuario" maxlength="20" readonly value="<?php echo htmlspecialchars($text_usuario); ?>" >
            </div>

           <div class="form-group">
            <label for="text_contra">Contraseña:</label>
               <div  class="password-wrapper">
                <input type="password" id="text_contra" name="text_contra" maxlength="15" autocomplete="off" value="<?php echo $text_contra; ?>" >
                <i id="togglePass" class="fa-solid fa-eye" onclick="togglePasswordVisibility()"></i>
               </div>
            </div>

            <div class="form-group">
                <label for="lsttipo">Tipo de usuario:</label>
                <select id="lsttipo" name="lsttipo">
                    <option value="" disabled <?php echo ($lst_tipo == '') ? 'selected' : ''; ?>>-- Seleccione una opción --</option>
                    <option value="administrador" <?php echo ($lst_tipo == 'administrador') ? 'selected' : ''; ?>>Administrador</option>
                    <option value="capturista" <?php echo ($lst_tipo == 'capturista') ? 'selected' : ''; ?>>Capturista</option>                    
               </select>
            </div>       

            <div class="form-group">
                <label for="text_nombre">Nombre</label>
                <!-- Standard text field -->
                <input type="text" id="text_nombre" name="text_nombre" maxlength="40" autocomplete="off" value="<?php echo htmlspecialchars($text_nombre); ?>" >
            </div>            
            
              <div style="display: flex; gap: 10px;">
                  <input value='Cancelar' onclick="regresar('usuario')" type='button' class="steampunk-btn"> 
                  <button type="submit" class="steampunk-btn" >Grabar</button> 
              </div>
        </form>
<!--     Mensaje de validación al pie de la página si existe -->
        <?php if (!empty($message)): ?>
            <div class="ledger-response">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </div>
    </body>
</html>