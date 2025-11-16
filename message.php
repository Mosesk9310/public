<style>
    label { display: block; margin-top: 10px; }
    input { display: block; margin-bottom: 10px; }
</style>

<?php
// OPTIONAL: Hide warnings in production (uncomment when live)
// error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED);
// ini_set('display_errors', 0);

// --- Database connection ---
$server = 'mysql';
$username = 'student';
$password = 'student';
$schema = 'csy2089';

try {
    $pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// --- Handle form submission ---
if (isset($_POST['submit'])) {
    // Basic input validation
    $firstname = trim($_POST['firstname']);
    $surname = trim($_POST['surname']);
    $email = trim($_POST['email']);
    $text = trim($_POST['text']);

    if ($firstname !== '' && $surname !== '' && $email !== '' && $text !== '') {
        // Check if the person already exists
        $checkStmt = $pdo->prepare('SELECT id FROM person WHERE firstname = :firstname AND surname = :surname AND email = :email');
        $checkStmt->execute([
            'firstname' => $firstname,
            'surname' => $surname,
            'email' => $email
        ]);
        $person = $checkStmt->fetch(PDO::FETCH_ASSOC);

        // If not found, insert a new person
        if (!$person) {
            $insertPerson = $pdo->prepare('INSERT INTO person (firstname, surname, email) VALUES (:firstname, :surname, :email)');
            $insertPerson->execute([
                'firstname' => $firstname,
                'surname' => $surname,
                'email' => $email
            ]);
            $personId = $pdo->lastInsertId();
        } else {
            $personId = $person['id'];
        }

        // Insert the message linked to that person
        $insertMsg = $pdo->prepare('INSERT INTO message (personid, text, date) VALUES (:personid, :text, NOW())');
        $insertMsg->execute([
            'personid' => $personId,
            'text' => $text
        ]);

        echo "<p style='color: green;'>Message sent successfully!</p>";
        echo '<a href="index1.php">Back to Home</a><hr>';
    } else {
        echo "<p style='color: red;'>Please fill in all fields before submitting.</p>";
    }
}

// --- Display messages ---
$stmt = $pdo->prepare('SELECT * FROM message ORDER BY date DESC');
$stmt->execute();

echo '<ul>';
foreach ($stmt as $row) {
    $personStmt = $pdo->prepare('SELECT * FROM person WHERE id = :id');
    $personStmt->execute(['id' => $row['personid']]);
    $person = $personStmt->fetch(PDO::FETCH_ASSOC);

    echo '<li>';
    if ($person) {
        $id = htmlspecialchars($person['id'] ?? '');
        $firstname = htmlspecialchars($person['firstname'] ?? '');
        $surname = htmlspecialchars($person['surname'] ?? '');
        echo "<strong>$id: $firstname $surname:</strong> ";
    } else {
        echo "<strong>Unknown Person (ID: " . htmlspecialchars($row['personid'] ?? '') . "):</strong> ";
    }

    $text = htmlspecialchars($row['text'] ?? '');
    $date = htmlspecialchars($row['date'] ?? '');
    echo "$text <em>$date</em>";
    echo '</li>';
}
echo '</ul>';
?>

<!-- --- Message form --- -->
<form action="" method="post">
    <label>Firstname</label>
    <input type="text" name="firstname" required />

    <label>Surname</label>
    <input type="text" name="surname" required />

    <label>Email</label>
    <input type="email" name="email" required />

    <label>Chat message</label>
    <input type="text" name="text" required />

    <input type="submit" name="submit" value="Submit" />
</form>
