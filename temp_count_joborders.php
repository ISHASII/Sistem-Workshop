<?php
// temp_count_joborders.php
// Reads .env for DB config and counts rows in job_orders table using PDO.
function env($key, $default = null) {
    static $data = null;
    if ($data === null) {
        $data = [];
        if (file_exists(__DIR__.'/.env')) {
            $lines = file(__DIR__.'/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos(trim($line), '#') === 0) continue;
                if (!strpos($line, '=')) continue;
                list($k, $v) = explode('=', $line, 2);
                $data[trim($k)] = trim($v);
            }
        }
    }
    return $data[$key] ?? $default;
}

$driver = env('DB_CONNECTION', 'mysql');
$db = env('DB_DATABASE');
$host = env('DB_HOST', '127.0.0.1');
$port = env('DB_PORT', '3306');
$user = env('DB_USERNAME');
$pass = env('DB_PASSWORD');

try {
    if ($driver === 'sqlite') {
        $path = $db ?: __DIR__.'/database/database.sqlite';
        $pdo = new PDO('sqlite:'.($path));
    } else {
        $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }
    $stmt = $pdo->query('SELECT COUNT(*) as c FROM job_orders');
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo intval($row['c']);
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}