<?php
$server = 'mysql';
$username = 'student';
$password = 'student';
$schema = 'csy2089';

$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password,
[ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);

$person = []; // Initialize $person to avoid errors in the form HTML

// --- SCENARIO 1: Handle Form Submission (UPDATE) ---
if (isset($_POST['submit'])) {
    $stmt = $pdo->prepare('UPDATE person SET 
        email = :email,
        firstname = :firstname,
        surname = :surname, 
        date_of_birth = :dob 
        WHERE id = :id');

    // All necessary keys are expected to be in $_POST here
    unset($_POST['submit']);
    $stmt->execute($_POST);

    echo "<P>Record updated successfully!</P>";
    echo "<a href='index1.php'>View Records</a>";

    // Re-fetch the updated record for display (or redirect)
    $stmt = $pdo->prepare('SELECT * FROM person WHERE id = :id');
    $stmt->execute(['id' => $_POST['id']]);
    $person = $stmt->fetch();
} 
// --- SCENARIO 2: Initial Page Load (SELECT) ---
else  {
    // Get the ID from the URL query string (e.g., edit.php?id=5)
    $stmt = $pdo->prepare('SELECT * FROM person WHERE email = :email');

    $values = [
        'email' => $_GET['email']
    ];

    $stmt->execute($values);
    $person = $stmt->fetch();
}
?>

<form action="edit.php" method="POST">
    <label for="ID">ID:</label>
    <input type="hidden" name="id" value="<?php echo $person['id'] ?? ''; ?>" />
    <br />
    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo $person['email'] ?? ''; ?>" />
    <br />
    <label for="firstname">First Name:</label>
    <input type="text" name="firstname" value="<?php echo $person['firstname'] ?? ''; ?>" />
    <br />
    <label for="surname">Surname:</label>
    <input type="text" name="surname" value="<?php echo $person['surname'] ?? ''; ?>" />
    <br />
    <label for="dob">Date of Birth:</label>
    <input type="date" name="dob" value="<?php echo $person['date_of_birth'] ?? ''; ?>" />
    <br />
    <input type="submit" name="submit" value="Update Record" />
</form>