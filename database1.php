
//database1.php

// This code connects to a MySQL database and retrieves records based on user input securely using prepared statements.
// this is a more secure version of data_base.php that prevents SQL injection attacks.
a code for listiing records from a database based on user input
<?php
$server = 'mysql';
$username = 'student';
$password = 'student';
//The name of the schema we created earlier in MySQL workbench
//If this schema does not exist you will get an error!


$schema = 'csy2089';
//$schema = 'csy2089_person';

$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
if (isset($_POST['submit'])) {

    //WARNING: The following code is VULNERABLE to SQL Injection attacks!  
//$records = $pdo->query('SELECT * FROM person Where surname = "' . $_POST['surname'] . '"');

$stmt = $pdo->prepare('SELECT firstname, surname FROM person WHERE surname = :surname');
// This binds the value from the form to the :surname placeholder in the SQL statement

// This is a safe way to include user input in SQL queries
$stmt->execute(['surname' => $_POST['surname']]);

//fetchAll returns an array of all the records found

foreach ($stmt as $row) {
    //var_dump($row); to see the structure of $row
    echo $row['firstname'] . '' . $row['surname'];

    echo '<br>';
}
}
?>

<form action="" method="POST">
    <input type="text" name="surname" />
    <input type="submit" name="submit" />
</form>

