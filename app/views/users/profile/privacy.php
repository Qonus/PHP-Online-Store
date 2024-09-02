<h3> Change email address: </h3>
<form action="" method="post">
    <input type="email" name="email" placeholder="Enter new email" value="<?= $email ?>" />
    <input type="submit" name="change_email" value="Save changes" />
</form>

<h3> Change password: </h3>
<form action="" method="post">
    <input type="password" name="old_password" placeholder="Enter the old password" />
    <input type="password" name="new_password" placeholder="Enter the new password" />
    <input type="password" name="confirm_new_password" placeholder="Confirm the new password" />
    <input type="submit" name="change_password" value="Save changes" />
</form>
<?php if (isset($error)): ?>
    <p class="error">
        <?= $error ?>
    </p>
<?php endif;
if (isset($message)): ?>
    <p class="message">
        <?= $message ?>
    </p>
<?php endif; ?>