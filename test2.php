<?php
// Database configuration
$host = 'localhost';
$dbname = 'your_database';
$user = 'your_username';
$password = 'your_password';

$row = null;
$error = null;

try {
    // Connect to PostgreSQL using PDO
    $dsn = "pgsql:host=$host;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Prepare and execute the query safely using a named parameter
    $stmt = $pdo->prepare("SELECT idsuc, dessuc FROM your_table_name WHERE idsuc = :idsuc");
    $stmt->execute(['idsuc' => 'uno']);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error = "Database connection or query failed: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PostgreSQL Row Display</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        table { border-collapse: collapse; width: 400px; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f8f9fa; }
        .error { color: #dc3545; }
    </style>
</head>
<body>

    <h2>Record Details</h2>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php elseif ($row): ?>
        <table>
            <tr>
                <th>Column</th>
                <th>Value</th>
            </tr>
            <tr>
                <td><strong>idsuc</strong></td>
                <td><?= htmlspecialchars($row['idsuc']) ?></td>
            </tr>
            <tr>
                <td><strong>dessuc</strong></td>
                <td><?= htmlspecialchars($row['dessuc']) ?></td>
            </tr>
        </table>
    <?php else: ?>
        <p>No record found where <code>idsuc</code> is 'uno'.</p>
    <?php endif; ?>

</body>
</html>