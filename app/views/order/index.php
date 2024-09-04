<div class="checkoutpage">
    <div class="checkoutpage-wrapper">
        <h2>Checkout</h2>
        <form action="" method="post">
            <!-- SELECT DELIVERY METHODS
                <?php foreach ($delivery_methods as $item):
                    $item = (array) $item;
                    ?>
                <input type="radio" name="delivery_method" value="<?= $item['method_name'] ?>">
                <label>
                    <?= $item['method_name'] ?>
                </label>
            <?php endforeach; ?> -->
            <input type="text" name="address" />
            <div class="checkoutpage__payment-methods">
                <div class="checkoutpage__payment-methods__method">
                    <input type="radio" name="payment_method" value="visa">
                    <label>Visa</label>
                </div>
                <div class="checkoutpage__payment-methods__method">
                    <input type="radio" name="payment_method" value="mastercard">
                    <label>Mastercard</label>
                </div>
                <div class="checkoutpage__payment-methods__method">
                    <input type="radio" name="payment_method" value="paypal">
                    <label>PayPal</label>
                </div>
            </div>

            <input type="submit" value="Order">
        </form>
    </div>
</div>