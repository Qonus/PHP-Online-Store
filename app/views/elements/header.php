<header>
    <nav>
        <ul style="display: flex; flex-direction: row; list-style; none; gap: 10px">
            <li><a href="/">Home</a></li>
            <li><a href="/categories/">Categories</a></li>
            <li><a href="/orders/">Orders</a></li>
            <li><a href="/products/">Products</a></li>
            <?php if (!isset($_SESSION["user"])): ?>
                <li><a href="/login/">Login</a></li>
            <?php else: ?>
                <li><a href="/logout/">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>