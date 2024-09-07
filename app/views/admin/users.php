<table>
    <tr>
        <th>User ID</th>
        <th>User Type</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Actions</th>
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
            <td>Remove | Edit</td>
        </tr>
    <?php endforeach; ?>
</table>