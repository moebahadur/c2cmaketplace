<?php
require 'db.php'; require 'auth.php';
$stmt = $pdo->query("SELECT p.*, u.name as seller FROM products p JOIN users u ON p.seller_id=u.id");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>C2C Marketplace</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <h2>Products</h2>
    <div class="row">
    <?php foreach($products as $p): ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5><?=htmlspecialchars($p['name'])?></h5>
                    <p><?=htmlspecialchars($p['description'])?></p>
                    <p>R<?=number_format($p['price'],2)?> | Seller: <?=htmlspecialchars($p['seller'])?></p>
                    <a href="product.php?id=<?=$p['id']?>" class="btn btn-primary">View</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>
</body>
</html>
