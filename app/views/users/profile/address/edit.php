<h2>Edit Address:</h2>
<form method="post">
    <input value="<?= $address['address_label'] ?>" placeholder="Address name (home, work, ect)" name="address_label"
        type="text"><br>
    <input value="<?= $address['address_line1'] ?>" placeholder="Address line 1" name="address_line1" type="text"><br>
    <input value="<?= $address['address_line2'] ?>" placeholder="Address line 2" name="address_line2" type="text"><br>
    <input value="<?= $address['city'] ?>" placeholder="City" name="city" type="text"><br>
    <input value="<?= $address['state'] ?>" placeholder="State" name="state" type="text"><br>
    <input value="<?= $address['postal_code'] ?>" placeholder="Postal code" name="postal_code" type="text"><br>
    <input value="<?= $address['country'] ?>" placeholder="Country" name="country" type="text"><br>
    <textarea name="address_comment" placeholder="Address comment"><?= $address['address_comment'] ?></textarea><br>
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
    <button type="submit">Update Address</button>
    <a href="/profile/address">Back</a>
</form>