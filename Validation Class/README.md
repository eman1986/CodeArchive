# Validation Class

## LEGAL

This code is provided AS-IS, and comes with NO support.
If you wish to improve the library, you are free to do so without my permission.
If you wish to give me credit, I welcome that but do not require it.

## INTRO

This validation class is a simple library that checks for valid email address, and checks for invalid characters.

## EXAMPLE

```php
// example form field data.
$name = $_POST['name'];
$name = $_POST['email'];
$age = $_POST['age'];
$password = $_POST['password'];

// call validation class.
$validate = new validation();

if (!$validate->validateAlpha($name)){
	die('This field can only accept letters.');
}

if (!$validate->validateNumeric($age)){
	die('This field can only accept numbers.');
}

if (!$validate->validateAlphaNumeric($password)){
	die('This field can only accept Numbers & letters.');
}

if (!$validate->validateEmail($email)){
	die('Invalid Email Address!');
}
```
