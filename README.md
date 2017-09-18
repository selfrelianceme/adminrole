Laravel 5 Admin Amazing feedback
======================
after install this packages, you need install base admin
[adminamazing](https://github.com/selfrelianceme/adminamazing)
and base roles
[roles](https://github.com/romanbican/roles)

-----------------
Install via composer
```
composer require selfreliance/adminrole
```

Add Service Provider to `config/app.php` in `providers` section
```php
Selfreliance\adminrole\AdminRoleServiceProvider::class,
```

Go to `http://myapp/admin/adminrole` to view admin amazing
