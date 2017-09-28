Laravel 5 Admin Amazing adminrole
======================

## Require
- [adminamazing](https://github.com/selfrelianceme/adminamazing)
- [roles](https://github.com/selfrelianceme/fixroles)

## How to install
-----------------
Install via composer
```
composer require selfreliance/adminrole
```
Move public fields for view customization

```
php artisan vendor:publish
``` 

## Functions
```php
/* 
  @ param $name (string)
  @ return 1 if found and return object, 0 if not found, -1 not found table
*/
function checkExistRole($name) // check whether there is a role
$this->checkExistRole('admin') // usage
```
## Demonstration

```
Create role
```
![alt tag](https://i.imgur.com/Zkx1zL2.png)
```
Delete/edit role
```
![alt tag](https://i.imgur.com/XHDtaec.png)
