
<?php
if ($_GET['name'] === 'Alice') {
    echo "Welcome, Alice!";
} else {
    echo "Hello, guest!";
}
?>


<form action="" method="Get">
    <input type="text" name="num1" placeholder="Enter first number" required>
    <input type="text" name="num2" placeholder="Enter second number" required>
    <input type="text" name="num3" placeholder="Enter third number" required>
    <input type="submit" value="Suemit">
</form>

<a href="input.php?name=moses">Moses</a>
<a href="input.php?name=Alice">Alice</a>
<a href="input.php?name=Bob">Bob</a>

<form action="" method="Get">
    <input type="text" name="name" placeholder="Enter your name" required>
    <input type="submit" value="Submit">
</form>

<?php
if (isset($_GET['name'])) {
    echo "Hello, " . htmlspecialchars($_GET['name']) . "!";
} else {
    echo "Hello, guest!";
}           
?>
<?php

if (isset($_GET['num1']) && isset($_GET['num2']) &&
 isset($_GET['num3']))
echo $_GET['num1'] + $_GET['num2']+$_GET['num3']; 
else
echo "Please provide num1, num2, and num3 parameters in the URL.";
echo "<br>";
?>