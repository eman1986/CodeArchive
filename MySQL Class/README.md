# MySQL Class

## LEGAL

This code is provided AS-IS, and comes with NO support.
If you wish to improve the library, you are free to do so without my permission.
If you wish to give me credit, I welcome that but do not require it.

## INTRO

This MySQL Wrapper class is a simple way to access your MySQL Database. This requires that you have MySQL enabled and
this does NOT use MySQLi, you MUST have mysql enabled for this class to work.

## EXAMPLE #1

```php
$db = New MySQLWrapper("localhost", "root", "password", "testdb");

$db->SQL = "DELETE FROM table WHERE id='1'";
$db->query();
```

## EXAMPLE #2

```php
$db = New MySQLWrapper("localhost", "root", "password", "testdb");

$db->SQL = "SELECT * FROM table WHERE id='1'";
$count = $db->affectedRows();

echo "We found ".$count." rows.";
```

## EXAMPLE #3

```php
$db = New MySQLWrapper("localhost", "root", "password", "testdb");

$db->SQL = "SELECT name FROM table WHERE id='1'";
$fetch = $db->fetchResults();

echo "hello ".$fetch['name'].".";
```

## EXAMPLE #4

```php
$db = New MySQLWrapper("localhost", "root", "password", "testdb");

#filters field, so we're safe from SQL Injection.
$id = $db->filterMySQL($_POST['id']);

$db->SQL = "DELETE FROM table WHERE id='$id'";
$db->query();
```

## EXAMPLE #5

```php
$db = New MySQLWrapper("localhost", "root", "password", "testdb");
$installedVersion = $db->dbVersion();

echo "This conenction has MySQL Version ".$installedVersion." installed.";
```
