<?php

$server = 'mysql';
$username = 'student';
$password = 'student';

//The name of the schema we created earlier in MySQL workbench
//If this schema does not exist you will get an error!
$schema = 'csy2089';

$pdo = new PDO('mysql:dbname=' . $schema . ';host=' 
. $server, $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['submit'])) {
    $stmt = $pdo->prepare('SELECT firstname, surname FROM person WHERE surname = :surname');
    $stmt->execute(['surname' => $_POST['surname']]);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($records as $row) {
        echo htmlspecialchars($row['firstname'], ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($row['surname'], ENT_QUOTES, 'UTF-8') . '<br>';
    }
}

?>

<form action="" method="POST">
    <input type="text" name="surname" />
    <input type="submit" name="submit" />
</form>