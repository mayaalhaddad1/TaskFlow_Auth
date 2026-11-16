<?php
session_start();
require_once "../config/database.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
   $name=trim($_POST["name"]);
   $email=trim($_POST["email"]);
   $password = $_POST["password"];
   $hashed_password = password_hash($password,PASSWORD_DEFAULT);
   try{
    $sql ="SELECT password FROM users WHERE  email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    if ($result->num_rows >0){
       echo "<script>alert('Email is Already Registered, Please login'); window.location.href='login.php';</script>";
      exit();  
    }else{
   

    $sql="INSERT INTO users (name , email , password ) VALUES (? , ?, ?) ";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("sss",$name,$email,$hashed_password);
    $stmt->execute();
    
    $_SESSION['user_id']=$conn->insert_id;
    $_SESSION['name']=$name;

    header("Location: dashboard.php");
    exit();
    }
   }catch(mysqli_sql_exception $e){
      echo "Something went wrong , Please try again";
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
        <title>Register -Task Flow</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="styles.css" rel="stylesheet">
</head>
 <body class="d-flex align-items-center py-4 bg-body-tertiary"> 
  <main class="form w-100 m-auto">
     <form method="POST" action=""> 
     <h1 class="h3 mb-3 fw-normal">Please Register</h1> 
     <div class="form-floating"> 
     <input type="text" class="form-control" id="floatingname" placeholder="Name" name="name">
     <label for="floatingname">Name</label>
    </div> 
     <div class="form-floating"> 
     <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email">
     <label for="floatingInput">Email address</label>
     </div>
     <div class="form-floating"> 
     <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
     <label for="floatingPassword">Password</label>
    </div> 
     <button class="btn btn-primary w-100 py-2" type="submit">Register</button>
 </form> 
</main>   
 </body>
  </html>
