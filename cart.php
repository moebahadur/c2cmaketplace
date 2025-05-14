<?php
require 'db.php'; require 'auth.php';
if(!is_logged_in() || !is_customer()) header('Location: login.php');
if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['product_id'])) {
    $pid = $_POST['product_id'];
    $qty = $_POST['quantity'];
    $_SESSION['cart'][$pid] = $qty;
    header('Location: cart.php');
    exit;
}

// Checkout
if(isset($_POST['checkout'])) {
    $total = 0;
    foreach($_SESSION['cart'] as $pid=>$qty) {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
        $stmt->execute([$pid]);
        $prod = $stmt->fetch();
        $total += $prod['price'] * $qty;
    }
    $pdo->beginTransaction();
    $stmt = $pdo->prepare("INSERT INTO orders (customer_id, total) VALUES (?,?)");
    $stmt->execute([$_SESSION['user']['id'], $total]);
    $oid = $pdo->lastInsertId();
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?,?,?,?)");
    foreach($_SESSION['cart'] as $pid=>$qty) {
        $stmt->execute([$oid, $pid, $qty, $prod['price']]);
    }
    $pdo->commit();
    $_SESSION['cart'] = [];
    $msg = "Order placed!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <h2>Your Cart</h2>
    <?php if(isset($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>
    <form method="post">
    <table class="table">
        <tr><th>Product</th><th>Qty</th><th>Price</th></tr>
        <?php
        $total = 0;
        foreach($_SESSION['cart'] as $pid=>$qty):
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
            $stmt->execute([$pid]);
            $prod = $stmt->fetch();
            $total += $prod['price'] * $qty;
        ?>
        <tr>
            <td><?=htmlspecialchars($prod['name'])?></td>
            <td><?=$qty?></td>
            <td>R<?=number_format($prod['price']*$qty,2)?></td>
        </tr>
        <?php endforeach; ?>
        <tr><td colspan="2">Total</td><td>R<?=number_format($total,2)?></td></tr>
    </table>
    <button name="checkout" class="btn btn-primary">Checkout</button>
    </form>
</div>
</body>
</html>
