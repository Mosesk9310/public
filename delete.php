<?php
$server = 'mysql';
$username = 'student';
$password = 'student';
//The name of the schema we created earlier in MySQL workbench
//If this schema does not exist you will get an error!
$schema = 'csy2089';
//Create a PDO instance to allow us to talk to the database
$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password,
[ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);

// Check if email parameter is set in the URL
// If it is, we prepare and execute the delete statement

{
    $stmt = $pdo->prepare('DELETE FROM person WHERE email = :email LIMIT 1');

    $values = [
        'email'=> $_POST['email']
];
    $stmt->execute($values);

    echo "Record deleted successfully!";
    echo '<br><a href="index.php">Back to Home</a>';

}
?>