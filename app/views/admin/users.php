<table>
    <tr>
        <th>User ID</th>
        <th>User Type</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Change User Type</th>
        <th>Order Details</th>
    </tr>
    <?php foreach ($users as $item):
        $item = (array) $item; ?>
        <tr>
            <td>
                <?= $item["user_id"] ?>
            </td>
            <td>
                <?= $item["user_type"] ?>
            </td>
            <td>
                <?= $item["first_name"] ?>
            </td>
            <td>
                <?= $item["last_name"] ?>
            </td>
            <td>
                <?= $item["email"] ?>
            </td>
            <td>
                <?= $item["phone"] ?>
            </td>
            <td>Make <a href="/admin/users/Administrator/<?= $item["user_id"] ?>">Admin</a> | <a href="/admin/users/Manager/<?= $item["user_id"] ?>">Manager</a> | <a href="/admin/users/Customer/<?= $item["user_id"] ?>">Customer</a></td>
            <?php if ($item["user_type"] == "Customer"): ?>
            <td><a href="/admin/customers/<?= $item["user_id"] ?>/orders">Details</a></td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>