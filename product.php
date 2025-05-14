<?php
require 'db.php'; require 'auth.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT p.*, u.name as seller FROM products p JOIN users u ON p.seller_id=u.id WHERE p.id=?");
$stmt->execute([$id]);
$p = $stmt->fetch();
if(!$p) die("Product not found");
?>
<!DOCTYPE html>
<html>
<head>
    <title><?=$p['name']?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <h2><?=htmlspecialchars($p['name'])?></h2>
    <p><?=htmlspecialchars($p['description'])?></p>
    <p>Price: R<?=number_format($p['price'],2)?></p>
    <p>Seller: <?=htmlspecialchars($p['seller'])?></p>
    <?php if(is_logged_in() && is_customer()): ?>
        <form method="post" action="cart.php">
            <input type="hidden" name="product_id" value="<?=$p['id']?>">
            <input type="number" name="quantity" value="1" min="1" max="<?=$p['quantity']?>" required>
            <button class="btn btn-success">Add to Cart</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
