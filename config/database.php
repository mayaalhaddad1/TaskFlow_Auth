<?php
$host = "localhost";
$db_name = "taskflow_db";
$user_name = "root";
$password = "";

try{
$conn = new mysqli($host , $user_name, $password , $db_name);
if($conn->connect_error){
    die("Connection Failed " .$conn->connect_error);
}
}catch(mysqli_sql_exception $e){
    die("Connection Failed " .$e->getMessage());
}

?>