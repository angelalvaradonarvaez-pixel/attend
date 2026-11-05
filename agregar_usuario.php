<?php
require_once './funciones_generales.php';
// Initialize variables for feedback message
$text_usuario = '';
$text_nombre = '';
$text_contra = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // POST request, process form submission
    // Capture and sanitize inputs
    $text_usuario = htmlspecialchars(trim($_POST['text_usuario'] ?? ''));
    $text_nombre = htmlspecialchars(trim($_POST['text_nombre'] ?? ''));
    $text_contra = htmlspecialchars(trim($_POST['text_contra'] ?? ''));
    // Validate fields
    $message = '';
    $message .= valida_campo($text_usuario, 'alfanumerico', 'Usuario', 'El');
    $message .= valida_campo($text_nombre, 'texto', 'Nombre', 'El');
    $message .= valida_campo($text_contra, 'password', 'Contraseña', 'La');
    if (empty($message)) {
        $url = 'graba_usuario.php?text_usuario=' . $_POST['text_usuario'];
        $url .= '&text_nombre=' . $_POST['text_nombre'];
        $url .= '&text_contra=' . $_POST['text_contra'];
        echo "<SCRIPT>window.location='$url';</SCRIPT>";
    } else {
        $text_usuario = strtoupper(trim($_REQUEST['text_usuario']));
        $text_nombre = strtoupper(trim($_REQUEST['text_nombre']));
        $text_contra = $_REQUEST['text_contra'];
    }
} else {  // GET request, initialize form fields with request parameters if available
    $text_usuario = strtoupper(trim($_REQUEST['text_usuario'] ?? ''));
    $text_nombre = strtoupper(trim($_REQUEST['text_nombre'] ?? ''));
    // $text_contra = $_REQUEST['text_contra'] ?? '';
    if (isset($_REQUEST['mensaje'])) {
        $message = $_REQUEST['mensaje'];
    } else {
        $message = '';
    }
}
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
    <h1>Agregar usuario</h1>
    <div class="steampunk-ledger">
        <form name='fsucursal' method="POST" action=''>            
            <div class="form-group">
                <label for="text_usuario">USUARIO</label>
                 <!-- Standard text field -->
                <input type="text" id="text_usuario" name="text_usuario" maxlength="15" autocomplete="off" value="<?php echo $text_usuario; ?>" >
            </div>
           
            <div class="form-group">
            <label for="text_contra">Contraseña:</label>
               <div  class="password-wrapper">
                <input type="password" id="text_contra" name="text_contra" maxlength="15" autocomplete="off" value="<?php echo $text_contra; ?>" >
                <i id="togglePass" class="fa-solid fa-eye" onclick="togglePasswordVisibility()"></i>
               </div>
            </div>

            <div class="form-group">
                <label for="country">Tipo de usuario:</label>
                <select id="country" name="country">
                    <option value="" disabled selected>-- Select an option --</option>
                    <option value="administrador">Administrador</option>
                    <option value="capturista">Capturista</option>                    
               </select>
            </div>       
       
            <div class="form-group">
                <label for="text_nombre">Nombre</label>
                <!-- Standard text field -->
                <input type="text" id="text_nombre" name="text_nombre" maxlength="40" autocomplete="off" value="<?php echo $text_nombre; ?>" >
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