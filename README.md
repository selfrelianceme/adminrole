Laravel 5 Admin Amazing adminrole
======================
after install this packages, you need install base admin
[adminamazing](https://github.com/selfrelianceme/adminamazing)
and base [roles](https://github.com/selfrelianceme/fixroles)

-----------------
Install via composer
```
composer require selfreliance/adminrole
```

Add Service Provider to `config/app.php` in `providers` section
```php
Selfreliance\adminrole\AdminRoleServiceProvider::class,
```

Go to `http://myapp/admin/adminrole/roles` or `http://myapp/admin/adminrole/permissions` to view admin amazing
