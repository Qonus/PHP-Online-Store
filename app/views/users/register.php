<form method='post' action="" name="login">
    <input name="first_name" type="text" <?= isset($first_name) ? "value='$first_name'" : ""?> placeholder="Enter your first name"/>
    <input name="last_name" type="text" <?= isset($last_name) ? "value='$last_name'" : ""?>" placeholder="Enter your last name"/>
    <input name="phone" type="text" <?= isset($phone) ? "value='$phone'" : ""?> placeholder="Enter your phone"/>
    <input name="email" type="email" <?= isset($email) ? "value='$email'" : ""?>" placeholder="Enter your email"/>
    <input name="password" type="password" placeholder="Enter your password"/>
    <input name="confirm_password" type="password" placeholder="Confirm your password"/>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif;?>
    <button type="submit"> Register </button>
    <a href="/login/">Already have an account?</a>
</form>