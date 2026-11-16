<?php
require_once "../config/database.php";
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$stmt=$conn->prepare("SELECT id , title ,description, priority , status ,due_date FROM tasks WHERE user_id = ? ORDER BY due_date ");
$stmt->bind_param("i",$_SESSION['user_id']);
$stmt->execute();
$tasks=$stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar border-bottom px-3">
      <span class="text-body-secondary"><?= htmlspecialchars($_SESSION["name"] ?? "User") ?></span>

    <span class="navbar-brand mb-0 h1 mx-auto">TaskFlow</span>
        <a href="logout.php" class="btn btn-outline-secondary">Logout</a>

</nav>

<main class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">My Tasks</h3>
        <a href="add_task.php" class="btn btn-primary">+ Add Task</a>
    </div>
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr><th>#</th><th>Title</th><th>Description</th><th>Priority</th><th>Status</th><th>Due</th><th class="text-end">Actions</th></tr>
                </thead>
                <tbody>
                <?php if ($tasks->num_rows == 0): ?>
                    <tr><td colspan="7" class="text-center py-4 text-body-secondary">No tasks yet</td></tr>
                <?php else: ?>
                   <?php $counter = 1; ?>
                    <?php while ($t = $tasks->fetch_assoc()): ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td><?= htmlspecialchars($t["title"]) ?></td>
                        <td><?= htmlspecialchars($t["description"]) ?></td>
                        <td><span class="badge text-bg-<?= $t["priority"]=="High" ? "danger" : ($t["priority"]=="Medium" ? "warning" : "secondary") ?>"><?= $t["priority"] ?></span></td>
                        <td><span class="badge text-bg-<?= $t["status"]=="Completed" ? "success" : ($t["status"]=="In Progress" ? "info" : "secondary") ?>"><?= $t["status"] ?></span></td>
                        <td><?= htmlspecialchars($t["due_date"]) ?></td>
                        <td class="text-end">
                            <a href="edit_task.php?id=<?= $t["id"] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="delete_task.php" class="d-inline" onsubmit="return confirm('Delete this task?');">
                                <input type="hidden" name="id" value="<?= $t["id"] ?>">
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

