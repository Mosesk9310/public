
<style>
    label {
        display: block;
        display: block;    }
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

if (isset($_POST['submit'])) {

if ($_POST['field'] == 'firstname' || $_POST['field'] == 'surname' || $_POST['field'] == 'email' || $_POST['field'] == 'date_of_birth') {
    $stmt = $pdo->prepare('SELECT * FROM person WHERE ' . $_POST['field'] . ' = :search');

    $values = [
        'search' => $_POST['search']
    ];
    $stmt->execute($values);

}
}

else {
    $stmt = $pdo->prepare('SELECT * FROM person');
    $stmt->execute();
}
?>

<form action="" method="POST">
    <label for="field">Search by:</label>
    <select name="field" required>
        <option value="firstname">First Name</option>
        <option value="surname">Surname</option>
        <option value="email">Email</option>
        <option value="date_of_birth">Date of Birth</option>
    </select>

    <label for="search">Search term:</label>
    <input type="text" name="search" required />

    <input type="submit" name="submit" value="Search" />
</form>

<?php

echo '<ul>';
foreach ($stmt as $row) {
    echo '<li>';
    echo '<a href="edit.php?id=' . $row['firstname'] . '' . $row['surname'] . '">' . $row['firstname'] . ' ' . $row['surname'] . '</a> - ' . $row['email'] . ' - ' . $row['date_of_birth'];
    echo '</li>';
}
echo '</ul>';
?>

