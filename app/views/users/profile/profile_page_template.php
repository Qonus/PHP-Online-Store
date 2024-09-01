<div class="profile">
    <div class="profile-wrapper">
        <div class="profile__tabs">
            <a href="/profile"
                class="profile__tab <?= ($page == "profile") ? "profile__tab--selected" : "" ?>">Profile</a>
            <a href="/profile/orders"
                class="profile__tab <?= ($page == "orders") ? "profile__tab--selected" : "" ?>">Orders</a>
            <a href="/profile/settings"
                class="profile__tab <?= ($page == "settings") ? "profile__tab--selected" : "" ?>">Settings</a>
            <a href="/profile/privacy"
                class="profile__tab <?= ($page == "privacy") ? "profile__tab--selected" : "" ?>">Privacy</a>
            <a href="/profile/address"
                class="profile__tab <?= ($page == "address") ? "profile__tab--selected" : "" ?>">Address</a>
        </div>
        <div class="profile__content">
            <?= $content ?>
        </div>
    </div>
</div>