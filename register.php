<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email']; $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $type = $_POST['type'];
    $stmt = $pdo->prepare("INSERT INTO users (email, password, name, user_type) VALUES (?, ?, ?, ?)");
    try {
        $stmt->execute([$email, $password, $name, $type]);
        header('Location: login.php');
    } catch (Exception $e) {
        $err = "Email already exists";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Register</h2>
    <?php if(isset($err)) echo "<div class='alert alert-danger'>$err</div>"; ?>
    <form method="post">
        <input name="name" class="form-control" placeholder="Name" required><br>
        <input name="email" type="email" class="form-control" placeholder="Email" required><br>
        <input name="password" type="password" class="form-control" placeholder="Password" required><br>
        <select name="type" class="form-control">
            <option value="customer">Customer</option>
            <option value="seller">Seller</option>
        </select><br>
        <button class="btn btn-primary">Register</button>
        <a href="login.php" class="btn btn-link">Login</a>
    </form>
</div>
</body>
</html>
