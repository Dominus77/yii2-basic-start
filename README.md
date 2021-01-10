# Yii2 Start Project Basic Template

[![Latest Stable Version](https://poser.pugx.org/dominus77/yii2-basic-start/v/stable)](https://packagist.org/packages/dominus77/yii2-basic-start)
[![License](https://poser.pugx.org/dominus77/yii2-basic-start/license)](https://packagist.org/packages/dominus77/yii2-basic-start)
[![Build Status](https://travis-ci.org/Dominus77/yii2-basic-start.svg?branch=master)](https://travis-ci.org/Dominus77/yii2-basic-start)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Dominus77/yii2-basic-start/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Dominus77/yii2-basic-start/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/Dominus77/yii2-basic-start/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Total Downloads](https://poser.pugx.org/dominus77/yii2-basic-start/downloads)](https://packagist.org/packages/dominus77/yii2-basic-start)

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
- users
- admin
- rbac (manage web interface)

Functional
- Reset password
- Confirmation by email
- Last visit
- Console commands
- RBAC

## CSS Themes Bootstrap

The template includes the of the CSS Theme Bootstrap

Switching the theme occurs in the `app/config/web.php`

## Requirements

The minimum requirement by this project template that your Web server supports PHP 5.6

## INSTALLATION

Create a project:

```bash
composer create-project --prefer-dist --stability=dev dominus77/yii2-basic-start basic-project
```

or clone the repository for `pull` command availability:

```bash
git clone https://github.com/Dominus77/yii2-basic-start.git basic-project
cd basic-project
composer install
```

Init an environment:

Run command in the root directory `public_html` of the project

if Development environment
```bash
composer app-init-dev
```
if Production environment
```bash
composer app-init-prod
```
otherwise choose Wednesday
```bash
php init
```

Create a database, default configure: `yii2_basic_start` in `app/config/common-local.php`
```php
$config = [
    //...
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=yii2_basic_start',
            //...
        ],
        //...
    ],
    //...
];
```

Apply migration:

```bash
composer migrate-up
```

Create users, enter the command and follow the instructions:

```bash
php yii users/user/create
```

- Username: set username;
- Email: set email username;
- Password: set password username (min 6 symbol);
- Status: set status username (0 - blocked, 1 - active, 2 - wait, ? - Help);

See all available commands:

```bash
php yii
```

### Initialize RBAC

When initialized, the user with ID:1 is assigned the SuperAdmin role.

```bash
composer rbac-init
```
A command to assign roles to other users:

```
php yii rbac/roles/assign
```
To untie:
```
php yii rbac/roles/revoke
```

You can then access the application through the following URL:

```
http://localhost/basic-project/web/
```

Create `.htaccess` file or add folder `app/web`
`
```apache
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

## Code Sniffer

```bash
composer check-style
```

## TESTING

Create a database, default configure `yii2_basic_start_test` in `app/config/test-local.php`

```php
$config = [
    //...
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=yii2_basic_start_test',
            //...
        ],
        //...
    ],
    //...
];
```

Apply migration:

```bash
composer migrate-test-up
```

#### Run in console

```bash
composer build
composer test
```
## License

The BSD License (BSD). Please see [License File](https://github.com/Dominus77/yii2-basic-start/blob/master/LICENSE.md) for more information.
