<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">C2C Marketplace</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <?php if(is_logged_in() && is_seller()): ?>
                <li class="nav-item"><a class="nav-link" href="seller_dashboard.php">Seller Dashboard</a></li>
            <?php endif; ?>
            <?php if(is_logged_in() && is_admin()): ?>
                <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Admin Panel</a></li>
            <?php endif; ?>
        </ul>
        <ul class="navbar-nav">
            <?php if(is_logged_in()): ?>
                <li class="nav-item"><span class="nav-link">Hi, <?=htmlspecialchars($_SESSION['user']['name'])?></span></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
