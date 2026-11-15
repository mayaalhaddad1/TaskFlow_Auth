<?php
require_once "../config/database.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
   $name=trim($_POST["name"]);
   $email=trim($_POST["email"]);
   $password = $_POST["password"];
   $hased_password = password_hash($password,PASSWORD_DEFAULT);
   try{

    $sql ="SELECT password FROM users WHERE  email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result=$stmt->get_result();
    if ($result->num_rows >0){
       echo "<script> alert('Email is Already Registered , Please login');
         window.location.href='login.php';
       </script>";
      exit;
    }
    $stmt->close();

    $sql="INSERT INTO users (name , email , password ) VALUES (? , ?, ?) ";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("sss",$name,$email,$hased_password);
    $stmt->execute();

    session_start();
    $_SESSION['user_id']=$conn->insert_id;
    $_SESSION['name']=$name;

    header("Location : dashboard.php");
    exit();
   }catch(mysqli_sql_exception $e){
      echo "Something went wrong , Please try again";
   }
   }else{
    echo "Invalid request";
   }




?>