<a href="addplatform.php">Add Platform</a>
<br><br>

<?php
// DB connection
$server   = 'mysql';
$username = 'student';
$password = 'student';
$schema   = 'csy2089';

try {
    $pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
    // show errors as exceptions (helpful while debugging)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If connection fails, show error and stop
    echo '<strong>DB connection error:</strong> ' . htmlspecialchars($e->getMessage());
    exit;
}

// If form posted -> insert new game
if (isset($_POST['submit'])) {
    try {
        $insert = $pdo->prepare('INSERT INTO game (name, platformId) VALUES (:name, :platformId)');
        $insert->execute([
            ':name'       => $_POST['name'] ?? '',
            ':platformId' => $_POST['platformId'] ?? null
        ]);
        echo '<p style="color:green;">Game "' . htmlspecialchars($_POST['name']) . '" added successfully.</p>';
    } catch (PDOException $e) {
        echo '<p style="color:red;"><strong>Insert error:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
}

// Load platforms for the select
try {
    $stmt = $pdo->prepare('SELECT * FROM platform'); // <-- check your actual table name here
    $stmt->execute();
    $platforms = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo '<p style="color:red;"><strong>Query error:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
    $platforms = [];
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add game</title>
</head>
<body>

<h2>Add Game</h2>

<!-- debug: show count of platforms found - remove in production -->
<p>Platforms found: <?php echo count($platforms); ?></p>

<form method="post" action="game.php">
    <label for="name">Game Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="platformId">Select Platform:</label><br>
    <select id="platformId" name="platformId" required>
        <?php
        if (count($platforms) === 0) {
            // No platforms: friendly message inside the select
            echo '<option value="">-- No platforms available --</option>';
        } else {
            // Build options from the rows
            foreach ($platforms as $row) {
                // adjust column names if your DB uses different ones (e.g. 'ID' or 'Name')
                $value = isset($row['id']) ? $row['id'] : (isset($row['ID']) ? $row['ID'] : '');
                $label = isset($row['name']) ? $row['name'] : (isset($row['Name']) ? $row['Name'] : '');
                echo '<option value="' . htmlspecialchars($value) . '">' . htmlspecialchars($label) . '</option>';
            }
        }
        ?>
    </select>
    <br><br>

    <input type="submit" name="submit" value="Add Game">
</form>



</body>
</html>
