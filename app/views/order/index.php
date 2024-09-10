<h2>Checkout</h2>
<form action="" method="post">
    <input type="text" name="address" />
    <div class="checkoutpage__payment-methods">
        <h2>Default Address:</h2>
        <select name="default_address">
            <option <?= ($default_address != "") ? "" : "selected" ?>>None</option>
            <?php foreach ($addresses as $item):
                $item = (array) $item; ?>
                <option <?= ($default_address == $item["address_label"]) ? "selected" : "" ?>>
                    <?= $item["address_label"] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <div class="payment-methods__method">
            <input type="radio" name="payment_method" value="visa">
            <label>Visa</label>
        </div>
        <div class="payment-methods__method">
            <input type="radio" name="payment_method" value="mastercard">
            <label>Mastercard</label>
        </div>
        <div class="payment-methods__method">
            <input type="radio" name="payment_method" value="paypal">
            <label>PayPal</label>
        </div>
    </div>

    <input type="submit" value="Order">
</form>