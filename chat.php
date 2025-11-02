<?php

$server = 'mysql';
$username = 'student';
$password = 'student';
$schema = 'csy2089';

$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
?>

<form action="" method="POST">
    <label for="firstname">First Name:</label>
    <input type="text" name="firstname" id="firstname" required>

    <label for="surname">Surname:</label>
    <input type="text" name="surname" id="surname" required>

    <label for="email">Age:</label>
    <input type="number" name="age" id="age" required>

    <input type="submit" name="submit" value="Add Person">
</form>