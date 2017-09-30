# Laravel 5 Admin Amazing adminrole
adminrole - a package that allows you to configure access to certain installed packages by adminamazing

## Require

- [adminamazing](https://github.com/selfrelianceme/adminamazing)
- [roles](https://github.com/selfrelianceme/fixroles)

## How to install

Install via composer
```
composer require selfreliance/adminrole
```

## Functions

```php
/*
  @ param $name (string)
  @ return 1 if found, 0 if not found, -1 not found table
*/
function checkExistRole($name) // check whether there is a role
$this->checkExistRole('admin') // usage

/*
  @ param $request (post)
*/
function create(Request $request) // create role, transmit data: name (required && more 2 symbol)

/*
  @ param $name (string)
  @ request type (get)
*/
function edit($name) // get all about role with $name and show blade 'edit'
$this->edit('admin') // usage

/*
  @ param $request (put)
*/
function update(Request $request) // update role, transmit data: name (required && more 2 symbol)
/*
  @ param $type, $name, $privilegions
  @ $type [1] then use this when a column with privileges is not created or [2] then created
*/

function attach($type, $name, $privilegions) // attach privileges to role
$this->attach(2, 'admin', ['admin','admin/adminrole']); // usage
// P.S 'admin', 'admin/adminrole' it's prefixes routing: adminamazing, adminrole

/*
  @ param $name (string)
  @ request type (delete)
*/
function delete($name) // delete role with $name, detach all users with this role
```
