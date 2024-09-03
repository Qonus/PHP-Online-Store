<?php if (isset($orders)): ?>

    <table>
        <tr>
            <th>No.</th>
            <th>Date</th>
            <th>Total Amount</th>
            <th>Status</th>
        </tr>
        <?php
        foreach ($orders as $item):
            $item = (array) $item; ?>
            <tr>
                <td>
                    <a href="/profile/orders/<?= $item['order_id'] ?>">
                        Order No.
                        <?= $item["order_id"] ?>
                    </a>
                </td>
                <td>
                    <?= $item["order_date"] ?>
                </td>
                <td>
                    <?= $item["total_amount"] ?>
                </td>
                <td>
                    <?= $item["status"] ?>
                </td>
            </tr>
            <?php
        endforeach;
        ?>
    </table>

<?php else: ?>
    <h2>You don't have any orders yet</h2>
<?php endif; ?>