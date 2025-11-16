<?php
$server = 'mysql';
$username = 'student';
$password = 'student';
$schema = 'csy2089';

$pdo = new PDO('mysql:host=' . $server . ';dbname=' . $schema, $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch platforms for dropdown
$platformStmt = $pdo->prepare('SELECT Id, Name FROM platform ORDER BY Name ASC');
$platformStmt->execute();
$platforms = $platformStmt->fetchAll();

// Insert a new game
if (isset($_POST['submit'])) {
    $stmt = $pdo->prepare('INSERT INTO game (name, genre, price, platformId)
                           VALUES (:name, :genre, :price, :platformId)');

    $stmt->execute([
        ':name'       => $_POST['name'],
        ':genre'      => $_POST['genre'],
        ':price'      => $_POST['price'],
        ':platformId' => $_POST['platformId']
    ]);

    echo "<p>Game '" . htmlspecialchars($_POST['name']) . "' added successfully.</p>";
}
?>

<h1>Add Game</h1>

<form method="post" action="addgame.php">

    <label for="name">Game Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="genre">Genre:</label>
    <input type="text" id="genre" name="genre" required>

    <label for="price">Price:</label>
    <input type="number" id="price" step="0.01" name="price" required>

    <label for="platformId">Platform:</label>
    <select id="platformId" name="platformId" required>
        <option value="">-- Select Platform --</option>

        <?php foreach ($platforms as $p): ?>
            <option value="<?= htmlspecialchars($p['Id']) ?>">
                <?= htmlspecialchars($p['Name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <br><br>
    <input type="submit" name="submit" value="Add Game">
</form>

<br>
<a href="game.php">Add New Platform</a>

