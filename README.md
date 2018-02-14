Basic start template on Yii2
============================

Source code of yii2-basic-start module structure.

- [Web page](http://dominus77.github.io/yii2-basic-start)
- [github.com](https://github.com/Dominus77/yii2-basic-start)

Base components
------

Pages
- Home
- Contact
- Sign Up
- Login

Modules
- admin
- main
- user

Functional
- Reset password
- Confirmation by email
- Last visit

System
- RBAC (php file)
- Manage users
- Console commands
- i18n

Requirements
------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.

Installation
------

Create a project:

~~~
composer global require "fxp/composer-asset-plugin:^1.4.2"
composer create-project --prefer-dist --stability=dev dominus77/yii2-basic-start basic-project
~~~

or clone the repository for `pull` command availability:

~~~
git clone https://github.com/Dominus77/yii2-basic-start.git basic-project
cd basic-project
composer global require "fxp/composer-asset-plugin:^1.4.2"
composer install
~~~

Init an environment:

~~~
php init
~~~

Create a database, default configure: yii2-basic-start

Apply migration:

~~~
php yii migrate
~~~

See all available commands:

~~~
php yii
~~~

Create user, enter the command and follow the instructions:

~~~
php yii user/users/create
~~~

- Username: set username;
- Email: set email username;
- Password: set password username (min 6 symbol);
- Roles: set roles username (user, moder, admin, ? - Help);
- Status: set status username (0 - blocked, 1 - active, 2 - wait, ? - Help);

Init an RBAC

~~~
php yii user/rbac/init
~~~

You can then access the application through the following URL:

~~~
http://localhost/basic-project/web/
~~~

Create .htaccess file or add folder \web

~~~
AddDefaultCharset utf-8
# Mod_Autoindex
<IfModule mod_autoindex.c>
  # Disable indexes
  Options -Indexes
</IfModule>

# Mod_Rewrite
<IfModule mod_rewrite.c>
  # Enable symlinks
  Options +FollowSymlinks
  # Enable mod_rewrite
  RewriteEngine On

  # If a directory or a file exists, use the request directly
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  # Otherwise forward the request to index.php
  RewriteRule . index.php
</IfModule>
~~~