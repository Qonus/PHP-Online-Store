<div class="profile">
    <div class="profile-wrapper">
        <div class="profile__tabs">
            <a href="/profile"
                class="profile__tab <?= (explode("/", $page)[0] == "profile") ? "profile__tab--selected" : "" ?>">Profile</a>
            <a href="/profile/orders"
                class="profile__tab <?= (explode("/", $page)[0] == "orders") ? "profile__tab--selected" : "" ?>">Orders</a>
            <a href="/profile/settings"
                class="profile__tab <?= (explode("/", $page)[0] == "settings") ? "profile__tab--selected" : "" ?>">Settings</a>
            <a href="/profile/privacy"
                class="profile__tab <?= (explode("/", $page)[0] == "privacy") ? "profile__tab--selected" : "" ?>">Privacy</a>
            <a href="/profile/address"
                class="profile__tab <?= (explode("/", $page)[0] == "address") ? "profile__tab--selected" : "" ?>">Address</a>
        </div>
        <div class="profile__content">
            <?= $content ?>
        </div>
    </div>
</div>