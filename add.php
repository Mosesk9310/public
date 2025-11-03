<style>
    /* Styling to make labels start on a new line */
    label {
        display: block;
    }
</style>
<?php

$server = 'mysql';
$username = 'student';
$password = 'student';

// The name of the schema we created earlier in MySQL workbench
// If this schema does not exist you will get an error!
$schema = 'csy2089';

// Create a PDO instance to allow us to talk to the database
try {
    $pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
    // Optional: Set PDO to throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection error gracefully
    exit('Database connection failed: ' . $e->getMessage());
}


if (isset($_POST['submit'])) {
    // The query now has 4 placeholders, matching the 4 data columns being inserted
    $stmt = $pdo->prepare('INSERT INTO person (email, firstname, surname, date_of_birth) 
    VALUES (:email, :firstname, :surname, :dob)');
    
    // The date_of_birth column in the DB corresponds to the 'dob' form field
    // It's a good practice to create a clean array of parameters
    $params = [
        'email' => $_POST['email'],
        'firstname' => $_POST['firstname'],
        'surname' => $_POST['surname'],
        'dob' => $_POST['dob'] // This maps to the date_of_birth column
    ];
    
    // We use the clean $params array which has 4 elements, matching the 4 placeholders.
    // This fixes the 'Invalid parameter number' error.
    if ($stmt->execute($params)) {
        echo "Record added successfully!";
    } else {
        echo "Failed to add record.";
    }

} else {
    // Display the HTML form if the 'submit' button hasn't been pressed
    ?>
    
    <form action="" method="POST">
        <Label for="id">ID (Ignored):</Label>
        <input type="number" name="id" />
        <br />

        <label for="phone">Phone number:</label>
        <input type="text" name="phone_number" />
        <br />

        <label for="address">Address:</label>
        <input type="text" name="address" />
        <br />
        
        <label for="email">Email:</label>
        <input type="email" name="email" required />
        
        <label for="firstname">First Name:</label>
        <input type="text" name="firstname" required />

        <br />
        
        <label for="surname">Surname:</label>
        <input type="text" name="surname" required />

        <br />

        <label for="dob">Date of Birth:</label>
        <input type="date" name="dob" required />
        
        <input type="submit" name="submit" value="Add Person" />
    </form>
    <?php
}
?>