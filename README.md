<h1> <img src="https://github.com/user-attachments/assets/2eec6106-12b0-485e-9e53-31cc3ef62725" width="30" height="30" /> PlaySphere </h1>

Online store for board games and entertainment products.

Project was made as a Step Academy PHP-Course examination project

# Instructions

## Prerequisites

- Install XAMPP

## Step 1: Initialization

- Clone the project in `C:\xampp\htdocs`
- Put the following code at the end of `C:\xampp\apache\conf\httpd.conf`

```
<VirtualHost *:80>
    DocumentRoot "C:\xampp\htdocs\PHP-Online-Store\public_html"
    ServerName localhost
    ServerAlias localhost
    <Directory "C:\xampp\htdocs\PHP-Online-Store\public_html">
        Options Indexes FollowSymLinks Includes ExecCGI
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

## Step 2: Database

- Start MySQL service in XAMPP and click admin to open phpMyAdmin
- Run [`this`](https://github.com/Qonus/PHP-Online-Store/blob/main/my_database.sql) sql query in phpMyAdmin

## Step 3: Running

- Start apache server in XAMPP
