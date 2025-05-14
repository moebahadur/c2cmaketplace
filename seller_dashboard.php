<?php
require 'db.php'; require 'auth.php';
if(!is_logged_in() || !is_seller()) header('Location: login.php');
$sid = $_SESSION['user']['id'];
if($_SERVER['REQUEST_METHOD']=='POST') {
    $stmt = $pdo->prepare("INSERT INTO products (seller_id, name, description, price, quantity) VALUES (?,?,?,?,?)");
    $stmt->execute([$sid, $_POST['name'], $_POST['desc'], $_POST['price'], $_POST['qty']]);
}
$stmt = $pdo->prepare("SELECT * FROM products WHERE seller_id=?");
$stmt->execute([$sid]);
$myprods = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <h2>My Products</h2>
    <form method="post" class="mb-3">
        <input name="name" placeholder="Product Name" required>
        <input name="desc" placeholder="Description" required>
        <input name="price" type="number" step="0.01" placeholder="Price" required>
        <input name="qty" type="number" placeholder="Qty" required>
        <button class="btn btn-success">Add Product</button>
    </form>
    <table class="table">
        <tr><th>Name</th><th>Description</th><th>Price</th><th>Qty</th></tr>
        <?php foreach($myprods as $p): ?>
        <tr>
            <td><?=htmlspecialchars($p['name'])?></td>
            <td><?=htmlspecialchars($p['description'])?></td>
            <td>R<?=number_format($p['price'],2)?></td>
            <td><?=$p['quantity']?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
