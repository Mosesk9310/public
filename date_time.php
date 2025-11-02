<?php

$server = 'mysql';
$username = 'student';
$password = 'student';

//The name of the schema we created earlier in MySQL workbench
//If this schema does not exist you will get an error!
$schema = 'csy2089';

$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . 
$server, $username, $password);
//=========================== --- IGNORE ---
// --- IGNORE ---
// --- IGNORE ---




$date = new DateTime('2025-10-27 12:00:00');
echo $date->format('\\T\\h\\e \\t\\i\\m\\e isD/M/Y H:i:s');
// this will output: The time is 27/10/2025 12:00:00
echo '<br />';

$date = new DateTime('2026-12-23 12:00:00');
echo $date->format('//T//h//e //t//i//m//e is H:i:s');

$date->modify('+12 days');
echo '<br />';



echo '<br>';

echo $date->format('y-m-d');

echo '<br>';

echo $date->format('m/d/y');
echo '<br>';





echo '<hr />';
$timestamp = strtotime('2025-10-27 12:00:00');

echo date('d-m-Y H:i:s', $timestamp);

echo '<br>';

echo date('y-m-d', $timestamp);

echo '<br>';

echo date('m/d/y', $timestamp);


?>