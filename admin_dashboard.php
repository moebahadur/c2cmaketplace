<?php
require 'db.php'; require 'auth.php';
if(!is_logged_in() || !is_admin()) header('Location: login.php');
$users = $pdo->query("SELECT * FROM users")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <h2>All Users</h2>
    <table class="table">
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Type</th></tr>
        <?php foreach($users as $u): ?>
        <tr>
            <td><?=$u['id']?></td>
            <td><?=htmlspecialchars($u['name'])?></td>
            <td><?=htmlspecialchars($u['email'])?></td>
            <td><?=$u['user_type']?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
