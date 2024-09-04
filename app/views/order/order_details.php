<?php if (isset($order) && isset($order_details)): ?>

    <h2>Order Details</h2>
    <table>
        <tr>
            <th>Total Amount</th>
            <td>
                <?= $order['total_amount'] ?>
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Product Price</th>
            <th>Total Price</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($order_details as $item):
            $item = (array) $item; ?>
            <tr>
                <td>
                    <?= $item['product_name'] ?>
                </td>
                <td>
                    <?= $item['quantity'] ?>
                </td>
                <td>
                    <?= $item['unit_price'] ?>
                </td>
                <td>
                    <?= $item['total_price'] ?>
                </td>
                <td>
                    <a href="/cart/add/<?= $item['product_id'] ?>">Order more</a>
                </td>

            </tr>
        <?php endforeach; ?>
    </table>

<?php endif; ?>