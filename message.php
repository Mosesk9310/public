
<style>
    label {  display: block;}
    input {display: block;}
    
</style>
<?php


$server = 'mysql';
$username = 'student';
$password = 'student';

//The name of the schema we created earlier in MySQL workbench
//If this schema does not exist you will get an error!
$schema = 'csy2089';

//Create a PDO instance to allow us to talk to the database

$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
$stmt = $pdo->prepare('SELECT * FROM message');
$stmt->execute();

echo '<ul>';
foreach ($stmt as $row) {
    // Fetch person data
    // Prepare statement to get person details
    $personSTMt = $pdo->prepare('SELECT * FROM person WHERE id = :id');
    // Execute the statement with the person ID
    $personSTMt->execute(['id' => $row['personid']]); // use personid to find the person
    // Fetch the person data
    $person = $personSTMt->fetch(PDO::FETCH_ASSOC);

    // Display list item: ID before name
    echo '<li>';
    // Display person details with ID first  
    echo '<strong>' . htmlspecialchars($person['id']) . ': ' . htmlspecialchars($person['firstname']) . ' ' . htmlspecialchars($person['surname']) . ':</strong> ';
    // Display message text and date 
    echo htmlspecialchars($row['text']);
    // Display date on a new line
    echo ' <em>' . htmlspecialchars($row['date']) . '</em>';
    echo '</li>';
}
echo '</ul>';



if (isset($_POST['submit'])) {

    $stmt = $pdo->prepare('INSERT INTO message (firstname, surname, email, text)
     VALUES (:firstname, :surname, :email, :text)');

    unset($_POST['submit']);
    $stmt->execute($_POST);

    echo "Message sent successfully!";
    echo '<br><a href="index1.php">Back to Home</a>';
}
?>

<form action="" method="post">
    <label>Firstname</label>
    <input type="text" name="firstname" />
    <label>Surname</label>
    <input type="text" name="surname" />
    <label>Email</label>
    <input type="text" name="email" />
    <label>Chat message</label>
    <input type="text" name="text" />
    <input type="submit" name="submit" value="Submit" />
</form>