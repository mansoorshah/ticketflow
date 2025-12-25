<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $host = $_POST['db_host'];
    $db   = $_POST['db_name'];
    $user = $_POST['db_user'];
    $pass = $_POST['db_pass'];

    try {
        $pdo = new PDO(
            "mysql:host=$host;charset=utf8mb4",
            $user,
            $pass,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db`");
        $pdo->exec("USE `$db`");

        $schema = file_get_contents("../database/schema.sql");
        $pdo->exec($schema);

        file_put_contents(
            "../config/config.php",
            "<?php\n define('DB_HOST','$host');\n define('DB_NAME','$db');\n define('DB_USER','$user');\n define('DB_PASS','$pass');"
        );

        echo "Installation successful. <a href='../public'>Go to app</a>";
        exit;

    } catch (Exception $e) {
        die("Install failed: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>TicketFlow Installer</title>
</head>
<body>
<h2>Install TicketFlow</h2>
<form method="post">
    <input name="db_host" placeholder="DB Host" value="localhost" required><br><br>
    <input name="db_name" placeholder="DB Name" required><br><br>
    <input name="db_user" placeholder="DB User" required><br><br>
    <input name="db_pass" placeholder="DB Password"><br><br>
    <button type="submit">Install</button>
</form>
</body>
</html>
