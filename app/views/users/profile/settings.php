<h3> Edit Profile </h3>
<form action="" method="post">
    <input type="text" name="first_name" placeholder="Enter first name" value="<?= $first_name ?>" />
    <input type="text" name="last_name" placeholder="Enter last name" value="<?= $last_name ?>" />
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
    <input type="submit" value="Save changes" />
</form>