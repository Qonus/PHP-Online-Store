<div class="cartpage">
    <div class="cartpage-wrapper">
        <h2>Shopping Cart:</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
            <?php
            if (isset($items)):
                foreach ($items as $item):
                    $item = (array) $item; ?>
                    <tr>
                        <td>
                            <a href="/product/<?= $item['product_id'] ?>">
                                <?= $item["product_name"] ?>
                            </a>
                        </td>
                        <td>
                            <?= $item["price"] ?>
                        </td>
                        <td>
                            <?= $item["quantity"] ?>
                        </td>
                        <td>
                            <?= $item["total"] ?>
                        </td>
                        <td>
                            <a href="/cart/remove/<?= $item["product_id"] ?>/">Delete</a><br>
                            <a href="/cart/set/<?= $item["product_id"] ?>/1/">Add one</a><br>
                            <a href="/cart/set/<?= $item["product_id"] ?>/-1/">Remove one</a><br>
                        </td>
                    </tr>
                    <?php
                endforeach;
            endif;
            ?>
        </table>
        <a href="/checkout">Checkout</a>
    </div>
</div>