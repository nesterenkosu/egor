<?php
$servername = "localhost";
$username = "root";
$password = "";

$connection = mysqli_connect($servername, $username, $password);

//echo "<pre>";var_dump($connection);echo "</pre>";

if (!$connection) 
    die("Ошибка подключения к серверу БД");

if(!mysqli_select_db($connection,"my_database"))
    die("Ошибка выбора БД");
//try {
//    $connaction = new PDO("mysql:host=$servername;dbname=my_database", $username, $password);
//}
//catch (PDOException $e){
//    echo "Не удалось подключиться: " . $e->getMessage();
//}
