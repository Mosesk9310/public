<?php
$server = 'mysql';
$username = 'student';
$password = 'student';
//The name of the schema we created earlier in MySQL workbench
//If this schema does not exist you will get an error!
$schema = 'csy2089';
$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
if (isset ($_POST['sumbit'])) {
$stmt = $pdo->prepare('SELECT * FROM person WHERE surname = :name');
$values = [
'name' => $_POST['surname']
];
$stmt->execute($values);
foreach ($stmt as $row) {
echo '<p>' . $row['firstname'] . '</p>';
}
}
?>

<form method="post" action="now.php">
    <input type="text" name="firstname" placeholder="Enter first name" required>
    <input type="text" name="surname" placeholder="Enter surname" required>
    <input type="submit" name="sumbit" value="Submit">
</form>