<form method='post' action="" name="login">
    <input name="email" type="email" placeholder="Enter your email" />
    <input name="password" type="password" placeholder="Enter your password" />
    <?php if (isset($error)): ?>
        <p style="color: red;">
            <?= $error ?>
        </p>
    <?php endif; ?>
    <button type="submit"> Login </button>
    <a href="/register">Don't have an account?</a>
</form>