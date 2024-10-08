<h2>Default Address:</h2>
<form method="post">
    <select name="default_address">
        <option <?= ($default_address != "") ? "" : "selected" ?>>None</option>
        <?php foreach ($addresses as $item):
            $item = (array) $item; ?>
            <option <?= ($default_address == $item["address_label"]) ? "selected" : "" ?>>
                <?= $item["address_label"] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <input name="set_default_address" type="submit" value="Set Default Address" />
</form>

<h2>Add Address:</h2>
<form method="post">
    <input placeholder="Address name (home, work, ect)" name="address_label" type="text"><br>
    <input placeholder="Address line 1" name="address_line1" type="text"><br>
    <input placeholder="Address line 2" name="address_line2" type="text"><br>
    <input placeholder="City" name="city" type="text"><br>
    <input placeholder="State" name="state" type="text"><br>
    <input placeholder="Postal code" name="postal_code" type="text"><br>
    <input placeholder="Country" name="country" type="text"><br>
    <textarea name="address_comment" placeholder="Address comment"></textarea><br>
    <input name="add_address" type="submit" value="Add Address" />
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

<?php if (isset($addresses)): ?>

    <table>
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th>Comment</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($addresses as $item):
            $item = (array) $item; ?>
            <tr>
                <td>
                    <?= $item["address_label"] ?>
                </td>
                <td>
                    <?= $item["city"] ?>
                    <?= $item["address_line1"] ?>
                    <?= $item["address_line2"] ?>
                </td>
                <td>
                    <?= $item["address_comment"] ?>
                </td>
                <td><a href="/profile/address/remove/<?= $item["address_id"] ?>">Remove</a> | <a
                        href="/profile/address/edit/<?= $item["address_id"] ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php else: ?>

    <h2>You don't have any addresses yet</h2>

<?php endif; ?>