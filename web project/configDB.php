<?php 
$host = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'restaurantthree';
if (!$dbConn= mysqli_connect($host,$dbUser,$dbPass)){
    
    die('Не може да осъществи връзка със сървъра.');
}

if (!mysqli_select_db($dbConn,$dbName)){
    
  die ('Не може да селектира от базата даннни.');
}

mysqli_query($dbConn,"SET NAMES 'UTF8'");



