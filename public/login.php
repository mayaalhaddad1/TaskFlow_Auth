<?php
session_start();
require_once "../config/database.php";
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email=trim($_POST["email"]);
    $password= $_POST["password"];
    $hashed_password = password_hash($password,PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT id , name , password From users Where email =?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    if($user && password_verify($password,$user["password"])){
        $_SESSION["user_id"]=$user["id"];
        $_SESSION["name"]=$user["name"];
        header("Location: dashboard.php");
        exit();
    } 
  
}

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="auto"> 
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Astro v5.18.2">
        <title>Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="styles.css" rel="stylesheet">
</head>
 <body class="d-flex align-items-center py-4 bg-body-tertiary"> 
  <main class="form w-100 m-auto">
     <form method="POST" action=""> 
      <h1 class="h3 mb-3 fw-normal">Please Login</h1> 
     <div class="form-floating"> 
     <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email">
     <label for="floatingInput">Email address</label>
     </div>
      <div class="form-floating"> 
     <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
     <label for="floatingPassword">Password</label>
     </div> 
     <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
 </form> 
</main>   
 </body>
  </html>
