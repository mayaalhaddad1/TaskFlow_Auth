<?php
require_once "../config/database.php";
session_start();
if(!isset($_SESSION["user_id"])){
    header("Location: dashboard.php");
    exit();
}
if(isset($_POST["id"])){
$task_id = (int)$_POST["id"];
$stmt=$conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $task_id, $_SESSION["user_id"]);
$stmt->execute();
header("Location: dashboard.php");
exit();
}