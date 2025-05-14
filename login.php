<?php
require 'db.php'; require 'auth.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$_POST['email']]);
    $u = $stmt->fetch();
    if ($u && password_verify($_POST['password'], $u['password'])) {
        $_SESSION['user'] = $u;
        header('Location: index.php');
    } else {
        $err = "Invalid login";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <?php if(isset($err)) echo "<div class='alert alert-danger'>$err</div>"; ?>
    <form method="post">
        <input name="email" type="email" class="form-control" placeholder="Email" required><br>
        <input name="password" type="password" class="form-control" placeholder="Password" required><br>
        <button class="btn btn-primary">Login</button>
        <a href="register.php" class="btn btn-link">Register</a>
    </form>
</div>
</body>
</html>
