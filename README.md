# Yii2 Start Project Basic Template

[![Build Status](https://travis-ci.org/Dominus77/yii2-basic-start.svg?branch=master)](https://travis-ci.org/Dominus77/yii2-basic-start)

The application is built using basic pattern and has a modular structure.

## Base components

Pages
- Home
- About
- Contact
- Check in
- Login
- Profile

Modules
- main
- user

Functional
- Reset password
- Confirmation by email
- Last visit
- Switch i18n
- Console commands

## CSS Themes Bootstrap

The template includes the of the CSS Theme Bootstrap

Switching the theme occurs in the `app/config/web.php`

## Requirements

The minimum requirement by this project template that your Web server supports PHP 5.5.0.

## INSTALLATION

Create a project:

```
composer create-project --prefer-dist --stability=dev dominus77/yii2-basic-start basic-project
```

or clone the repository for `pull` command availability:

```
git clone https://github.com/Dominus77/yii2-basic-start.git basic-project
cd basic-project
composer install
```

Init an environment:

```
php init
```

Create a database, default configure: yii2basic_start

Apply migration:

```
php yii migrate
```

See all available commands:

```
php yii
```

Create user, enter the command and follow the instructions:

```
php yii user/user/create
```

- Username: set username;
- Email: set email username;
- Password: set password username (min 6 symbol);
- Status: set status username (0 - blocked, 1 - active, 2 - wait, ? - Help);

You can then access the application through the following URL:

```
http://localhost/basic-project/web/
```

Create .htaccess file or add folder \web

```
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
```

## TESTING

Create a database, default configure yii2basic_start_test in app\config\test-local.php

```
//...
'components' => [
    'db' => [
        'dsn' => 'mysql:host=localhost;dbname=yii2basic_start_test',
    ],
]
//...
```

Apply migration:

```
php yii_test migrate/up
```

Run in console for Windows system:
```
vendor\bin\codecept build
vendor\bin\codecept run
```
Other:
```
vendor/bin/codecept build
vendor/bin/codecept run
```
