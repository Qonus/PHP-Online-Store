<header class="header">
    <div class="header-wrapper">
        <a class="header__logo" href="/">
            <img class="header__nav" src="/assets/sphere.svg" alt="sphere logo" />
            <h2>PlaySphere</h2>
        </a>
        <div class="header__nav">
            <li><a href="/categories/">categories</a></li>
            <li><a href="/products/">products</a></li>
            <?php if (!isset($_SESSION["user"])): ?>
                <li><a href="/login/">login</a></li>
            <?php else: ?>
                <li><a href="/cart/">cart</a></li>
                <li><a href="/profile/">profile</a></li>
                <li><a href="/logout/">logout</a></li>
            <?php endif; ?>
        </div>

    </div>
</header>