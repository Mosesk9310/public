<?php
$server = 'mysql';
$username = 'student';
$password = 'student';
$schema = 'csy2089';

$pdo = new PDO('mysql:host=' . $server . ';dbname=' . $schema, $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['submit'])) {
    $stmt = $pdo->prepare('INSERT INTO message (text, personid)
        VALUES (:text, :personid)');
    unset($_POST['submit']);
    $stmt->execute($_POST);
}

$stmt = $pdo->prepare('SELECT * FROM message');
$stmt->execute();

echo '<ul>';
foreach ($stmt as $row) {
    $personStmt = $pdo->prepare('SELECT * FROM person WHERE id = :id');
    $personStmt->execute(['id' => $row['personid']]);
    $person = $personStmt->fetch(PDO::FETCH_ASSOC);

    // Protect against missing or null data
    $firstname = $person['firstname'] ?? 'Unknown';
    $surname   = $person['surname'] ?? '';
    $text      = $row['text'] ?? '';
    $date      = $row['date'] ?? '';

    echo '<li><strong>' . htmlspecialchars($row['personid']) . ': ' .
         htmlspecialchars($firstname) . ' ' . htmlspecialchars($surname) .
         ':</strong> ' . htmlspecialchars($text) .
         ' <em>' . htmlspecialchars($date) . '</em></li>';
}
echo '</ul>';
?>

<form action="" method="POST">
    <label>Who are you?</label>
    <select name="personid">
        <?php
        $personStmt = $pdo->prepare('SELECT * FROM person');
        $personStmt->execute();
        foreach ($personStmt as $person) {
            echo '<option value="' . htmlspecialchars($person['id']) . '">' .
                 htmlspecialchars($person['firstname']) . ' ' . htmlspecialchars($person['surname']) .
                 '</option>';
        }
        ?>
    </select>
    <label>Chat message</label>
    <input type="text" name="text" required />
    <input type="submit" name="submit" value="Submit" />
</form>

