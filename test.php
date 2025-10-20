<?php
echo'<h1>My First PHP script</h1>';
echo "Hello World!";
?>

<?php
echo "This is a simple PHP script.";
?>

<?php
$rand = rand(1, 10);
if ($rand >= 5) {
    echo "Greater than or equal to 5";
} else {
    echo "Less than 5";
}