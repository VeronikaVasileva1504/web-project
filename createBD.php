<?php

$host = 'localhost';
$dbUser = 'root';
$dbPass = '';
if (!$dbConn= mysqli_connect($host,$dbUser,$dbPass)){
    
    die('Не може да осъществи връзка със сървъра.');
}
$sql='CREATE Database restaurantthree';
if ($queryResource == mysqli_query($dbConn, $sql)){
    
    echo "Базата данни е създадена!<br>";
}
else 
{
    echo "Грешка при създаване на базата данни!";
}








?>