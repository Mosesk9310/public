
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
    $stmt = $pdo->prepare('INSERT INTO person (email, firstname, surname, date_of_birth) 
    VALUES (:email, :firstname, :surname, :dob)');
    
unset($_POST['submit']); // Remove submit from the POST array
    $stmt->execute($_POST);
    echo "Record added successfully!";
} else {
    ?>
    

    <form action="" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" required />
        
        <label for="firstname">First Name:</label>
        <input type="text" name="firstname" required />
        
        <label for="surname">Surname:</label>
        <input type="text" name="surname" required />
        
        <label for="dob">Date of Birth:</label>
        <input type="date" name="dob" required />
        
        <input type="submit" name="submit" value="Add Person" />
    </form>
    <?php
}
?>