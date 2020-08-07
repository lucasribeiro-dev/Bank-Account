<?php

//Config DB
$dsn = "mysql:dbname=banco;host=localhost";
$dbuser = "root";
$dbpass = "";

//Connection with DB
try{
    $pdo = new PDO($dsn, $dbuser, $dbpass);

}catch(PDOExcepetion $e){
    echo "ERROR : ". $e->getMessage();
}
?>