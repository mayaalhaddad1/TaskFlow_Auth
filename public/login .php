<?php
session_start();
require_once "../config/database.php";

if($_SERVER[$_REQUEST_METHOD]=="POST"){
    $email=trim($_POST["email"]);
    $password = $_POST["password"];
    $hased_password = password_hash($password,PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT id , name , password From users Where email =?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    if($user && password_verify($password,$user["password"])){
        $_SESSION["user_id"]=$user["id"];
        $_SESSION["name"]=$user["name"];
        header("Location : dashboard.php");
        exit();
    } 
  
}

?>
<!DOCTYPE html>
<html lang ="en">
<head>
 <title>Login Page</title>
 <meta  charset="UTF-8" name="viewport" content="width=device-width , initial-scale =1.0" >
 </head>
 <body>
  <h2> Login Form</h2>
  <form method="POST" action="">
   <label> Email : </label><br>
   <input type="email" name="email" placeholder="Enter your email" required><br>
   <label> Password : </label><br>
   <input type="password" name="password" placeholder="Enter your password" required><br>
   <button type="submit">Login</button>
   
  </form>
</body>
</html>