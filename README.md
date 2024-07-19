# PHP-Online-Store

Step Academy PHP-Course examination project

## Put the following code at the end of `C:\xampp\apache\conf\httpd.conf`

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
