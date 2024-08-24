<header class="header">
    <div class="header-wrapper">
        <div class="header__nav">
            <li><a href="/">Home</a></li>
            <li><a href="/categories/">Categories</a></li>
            <li><a href="/products/">Products</a></li>
            <?php if (!isset($_SESSION["user"])): ?>
                <li><a href="/login/">Login</a></li>
            <?php else: ?>
                <li><a href="/cart/">Cart</a></li>
                <li><a href="/profile/">Profile</a></li>
                <li><a href="/logout/">Logout</a></li>
            <?php endif; ?>
        </div>

    </div>
</header>