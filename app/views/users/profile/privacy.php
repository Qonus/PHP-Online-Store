<h3> Change email address: </h3>
<form action="" method="post">
    <input type="email" name="email" placeholder="Enter new email" value="<?= $email ?>" />
    <input type="submit" value="Save changes" />
</form>

<h3> Change password: </h3>
<form action="" method="post">
    <input type="password" name="oldPassword" placeholder="Enter the old password" />
    <input type="password" name="newPassword" placeholder="Enter the new password" />
    <input type="submit" value="Save changes" />
</form>