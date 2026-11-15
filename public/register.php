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
}

?>
<!DOCTYPE html>
<html lang ="en">
    <head>
      <title>Register Form </title>
      <meta  charset="UTF-8" name="viewport" content="width=device-width , initial-scale =1.0" >
    </head>
<body>
 <h2>Register Form </h2>
  <form method="POST" action ="">
      <label> Name : </label><br>
      <input type ="text" name="name" placeholder="Enter your Full Name" required><br>
      <label> Email : </label><br>
      <input type ="email" name="email" placeholder="Enter your Email" required><br>
      <label> Password : </label><br>
      <input type ="password" name="password" placeholder="Enter your password" required><br>
      <button type="submit">Create Account </button>

</form>

</body>
</html>