<?php
require_once("../config/database.php");
session_start();

if(!isset($_SESSION["user_id"])){
    header("Location : login.php");
    exit();
}

$error="";
$id = (int)($_GET["id"] ?? $_POST["id"] ?? 0);

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $title=trim($_POST["title"]);
    $description=trim($_POST["description"]);
    $priority =$_POST["priority"];
    $status =$_POST["status"];
    $due_date =$_POST["due_date"];
     
    if(!(in_array($priority,["Low","Medium","High"])) ||
     !(in_array($status,["Pending","In Progress","Completed"]))){
      $error="Invalid Priority Or Status";
    }elseif($title==="" || $description==="" || $due_date===""){
      $error="Please Fill in all fields";
    }else{
     $stmt=$conn->prepare("UPDATE tasks SET title =?, description=?, priority=?, status=?, due_date=?  WHERE id=? AND user_id =?");
     $stmt->bind_param("sssssii",$title,$description,$priority,$status,$due_date,$id,$_SESSION["user_id"]);
     $stmt->execute();
     header("Location:dashboard.php");
     exit();
}
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Task - TaskFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5" style="max-width: 720px;">
    <h2 class="mb-4">Add Task</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="row g-3">
            <div class="col-12">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" maxlength="100"
                       value="<?= htmlspecialchars($_POST["title"] ?? "") ?>" required>
            </div>
            <div class="col-12">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3" required>
                    <?= htmlspecialchars($_POST["description"] ?? "") ?></textarea>
            </div>
            <div class="col-md-4">
                <label for="priority" class="form-label">Priority</label>
                <select name="priority" id="priority" class="form-select">
                    <option>Low</option>
                    <option selected>Medium</option>
                    <option>High</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option selected>Pending</option>
                    <option>In Progress</option>
                    <option>Completed</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="due_date" class="form-label">Due date</label>
                <input type="date" name="due_date" id="due_date" class="form-control" required>
            </div>
        </div>
        <hr class="my-4">
        <div class="d-flex gap-2">
            <button class="btn btn-primary" type="submit">Save Task</button>
            <a href="dashboard.php" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>