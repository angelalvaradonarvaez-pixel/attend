<?php
// Database configuration
$host     = 'localhost';
$port     = '5432';
$dbname   = 'Ejemplos';
$username = 'postgres'; // Replace with your PostgreSQL user
$password = 'harryh'; // Replace with your PostgreSQL password

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

try {
    // Establish secure PDO connection
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    die("<div style='font-family: sans-serif; padding: 20px; color: #721c24; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px;'>
            <strong>Database Connection Error:</strong> " . htmlspecialchars($e->getMessage()) . "
         </div>");
}

// Tables to inspect (Note: PostgreSQL table names are case-sensitive if created with quotes)
$tables = ['patrones','Biometricos','Departamentos','Empresa','PeriodoInicio','Sucursales','Turnos','empleados','usuarios'];

/**
 * Fetch column metadata from information_schema
 */
function getTableStructure($pdo, $tableName) {
    $sql = "SELECT 
                column_name, 
                data_type, 
                character_maximum_length, 
                is_nullable, 
                column_default 
            FROM information_schema.columns 
            WHERE table_schema = 'public' 
              AND (table_name = :tableName OR table_name = LOWER(:tableName))
            ORDER BY ordinal_position";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['tableName' => $tableName]);
    return $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Schema Inspector - central</title>
    <style>
        :root {
            --primary: #2c3e50;
            --accent: #2980b9;
            --bg: #f8f9fa;
            --card-bg: #ffffff;
            --text: #333333;
            --border: #e2e8f0;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            margin: 0;
            padding: 40px 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        header {
            margin-bottom: 30px;
            border-bottom: 2px solid var(--border);
            padding-bottom: 15px;
        }
        h1 {
            color: var(--primary);
            margin: 0 0 5px 0;
            font-size: 1.8rem;
        }
        .subtitle {
            color: #64748b;
            font-size: 0.95rem;
        }
        .table-card {
            background: var(--card-bg);
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            margin-bottom: 30px;
            overflow: hidden;
            border: 1px solid var(--border);
        }
        .table-header {
            background: var(--primary);
            color: #ffffff;
            padding: 15px 20px;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .table-header span {
            font-size: 0.85rem;
            background: rgba(255, 255, 255, 0.15);
            padding: 3px 10px;
            border-radius: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        th, td {
            padding: 12px 20px;
            border-bottom: 1px solid var(--border);
            font-size: 0.9rem;
        }
        th {
            background-color: #f1f5f9;
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }
        tr:last-child td {
            border-bottom: none;
        }
        tr:hover td {
            background-color: #f8fafc;
        }
        .badge-yes {
            color: #0d9488;
            background: #f0fdfa;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 500;
        }
        .badge-no {
            color: #475569;
            background: #f1f5f9;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 500;
        }
        .code {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 0.85rem;
            color: #d97706;
        }
        .empty-notice {
            padding: 20px;
            color: #dc2626;
            font-style: italic;
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>PostgreSQL Schema Inspector</h1>
        <div class="subtitle">Database: <strong><?= htmlspecialchars($dbname) ?></strong> &bull; Host: <strong><?= htmlspecialchars($host) ?></strong></div>
    </header>

    <?php foreach ($tables as $tbl): ?>
        <?php $columns = getTableStructure($pdo, $tbl); ?>
        <div class="table-card">
            <div class="table-header">
                <div>Table: <?= htmlspecialchars($tbl) ?></div>
                <span><?= count($columns) ?> Columns</span>
            </div>
            
            <?php if (empty($columns)): ?>
                <div class="empty-notice">Table <code><?= htmlspecialchars($tbl) ?></code> was not found in the public schema or contains no columns. (Check if table naming case matches PostgreSQL identifiers).</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Column Name</th>
                            <th>Data Type</th>
                            <th>Max Length</th>
                            <th>Nullable</th>
                            <th>Default Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($columns as $col): ?>
                            <tr>
                                <td class="code"><strong><?= htmlspecialchars($col['column_name']) ?></strong></td>
                                <td><?= htmlspecialchars($col['data_type']) ?></td>
                                <td><?= htmlspecialchars($col['character_maximum_length'] ?? '-') ?></td>
                                <td>
                                    <?php if ($col['is_nullable'] === 'YES'): ?>
                                        <span class="badge-yes">YES</span>
                                    <?php else: ?>
                                        <span class="badge-no">NO</span>
                                    <?php endif; ?>
                                </td>
                                <td class="code"><?= htmlspecialchars($col['column_default'] ?? 'NULL') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

</div>

</body>
</html>