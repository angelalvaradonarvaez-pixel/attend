<?php
require_once './definitions.php';
require_once './menu_functions.php';

if (isset($_REQUEST['mensaje'])) {
    $message = $_REQUEST['mensaje'];
} else {
    $message = '';
}
// Database Configuration (Update with your PostgreSQL credentials)
$host = 'localhost';
$port = '5432';
$dbname = 'Ejemplos';
$user = 'postgres';
$password = 'harryh';

$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
$dbconn = @pg_connect($conn_string);

// Pagination & Limit configuration
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
if ($limit <= 0) {
    $limit = 5;
}  // Default fallback

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page <= 0) {
    $page = 1;
}

$offset = ($page - 1) * $limit;

$total_rows = 0;
$total_pages = 1;
$records = [];
$db_error = '';

if ($dbconn) {
    // 1. Get total record count for pagination math
    $count_result = @pg_query($dbconn, 'SELECT COUNT(*) FROM public."Sucursales"');
    if ($count_result) {
        $total_rows = (int) pg_fetch_result($count_result, 0, 0);
        $total_pages = max(1, ceil($total_rows / $limit));
    }

    // Ensure page doesn't exceed total pages
    if ($page > $total_pages) {
        $page = $total_pages;
        $offset = ($page - 1) * $limit;
    }

    // 2. Fetch paginated records (assuming table 'Sucursales' with text fields: dessuc & idsuc)
    $query = 'SELECT   idsuc, dessuc FROM public."Sucursales" ORDER BY idsuc DESC LIMIT $1 OFFSET $2';
    $result = @pg_query_params($dbconn, $query, array($limit, $offset));

    if ($result) {
        while ($row = pg_fetch_assoc($result)) {
            $records[] = $row;
        }
    } else {
        $db_error = "Failed to query the registry table. Ensure table 'Sucursales' exists.";
    }
} else {
    $db_error = 'Failed to connect to PostgreSQL database. Please check your connection parameters.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Sucursales</title>
    <script type="text/javascript" src="./js/funciones.js"></script>
      <link rel="stylesheet" href="./css/style.css">
     <link rel="stylesheet" href="./css/style2.css">
      <link rel="stylesheet" href="./css/style_captura.css">
    <!-- Import Victorian-style serif font -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=IM+Fell+English&display=swap" rel="stylesheet">
  
</head>
<body>

    <h1>Sucursales</h1>
     <?php echo sucursales_steampunk_menu($menu_sucursales); ?>
     <br>
    <div class="steampunk-container">
        <?php if (!empty($db_error)): ?>
            <div class="error-box">
                <?php echo htmlspecialchars($db_error); ?>
            </div>
        <?php endif; ?>
        <!-- Rows per page selector form -->
        <form method="GET" action="" class="controls-bar">
            <div>
                <label for="limit">Registros por página:</label>
                <select name="limit" id="limit" onchange="this.form.submit()">
                    <option value="3" <?php if ($limit == 3) echo 'selected'; ?>>3</option>
                    <option value="5" <?php if ($limit == 5) echo 'selected'; ?>>5</option>
                    <option value="10" <?php if ($limit == 10) echo 'selected'; ?>>10</option>
                    <option value="20" <?php if ($limit == 20) echo 'selected'; ?>>20</option>
                </select>
            </div>
            <!-- Preserve page context or reset to 1 on limit modification -->
            <input type="hidden" name="page" value="1">
        </form>
        <!-- Data Grid Table -->
        <table class="ledger-table">
            <thead>
                <tr>
                    <th></th> 
                    <th>ID</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($records)): ?>
                    <?php foreach ($records as $row): ?>
                        <tr>                            
                            <td><input value='-' alt='Borrar' onclick='confirma_borrado("<?php echo $row['idsuc']; ?>","sucursal")' type='button' ></td>   
                            <td><a href='editar_sucursal.php?idsuc=<?php echo $row['idsuc']; ?>'><?php echo htmlspecialchars($row['idsuc']); ?></a></td>                                          
                            <td><?php echo htmlspecialchars($row['dessuc']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="no-records">No se encontraron registros.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <!-- Pagination Controls -->
        <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo ($page - 1); ?>&limit=<?php echo $limit; ?>" class="page-btn">&laquo; Previo</a>
                <?php endif; ?>

                <span class="page-info">Página <?php echo $page; ?> de <?php echo $total_pages; ?></span>

                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo ($page + 1); ?>&limit=<?php echo $limit; ?>" class="page-btn">Siguiente &raquo;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
      <?php if (!empty($message)): ?>
            <div class="ledger-response">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
</body>
</html>