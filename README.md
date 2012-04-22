PHP Parser API
==============

This project is a wrapper or facade of the PHP Parser[1] written by [nikic][2].
It's implemented as a TYPO3 extension but can be easily used as a stand-alone library.
The PHP Parser is included as sub module. Actually it's a fork of the Parser of nikic, since we needed more support for whitespaces and single line comments.

Documentation can be found in the [1] directory.

***Note: This is still in alpha state, so the API is subject to change.***

What is this for?
-----------------

This library provides an API to parse, "understand", manipulate and rewrite PHP classes, functions, methods etc.

For example:
```php
<?php
$phpFileObject = ParserService->parseFile('pathToFile');
$classObjects = $phpFileObject->getClasses();

foreach($classObjects as $classObject) {
	if($classObject->hasMethod('foo')) {
		$classObject->getMethod('foo')->setName('bar');
	}
}

$PHPCode = PrinterService->renderFileObject($phpFileObject);
```

It can also create classes or merge methods from various classes into one etc.

```php
<?php

$newClass = new Tx_PhpParser_Domain_Model_Class('MyNewClassName');
$newClass->setDescription("This is a class created\nfrom scratch")
	->setTag('author','John Doe')
	->setMethod($existingClass->getMethod('getFoo'))
	->setMethod($existingClass->getMethod('setFoo'));

$newProperty2 = new Tx_PhpParser_Domain_Model_Class_Property('foo');
$newProperty2->setDescription('foo')
	->setValue(array('foo'=>123))
	->setTag('var', 'array $foo')
	->setModifier('private');

$PHPCode = PrinterService->renderClassObject($newClass);
```

What else can it do?
--------------------
The library is extendable with your own class factories or Node-Visitors.
Currently the printer tries to render TYPO3 CGL compliant code. The library also provides methods to add, remove or change annotations in the doc comments.
For example it adds @param tags in methods (if they are missing) according to the parameter type hints.

Have a look at the Unit and Function tests in the [Tests][3] directory to see some examples.




 [1]: https://github.com/nikic/PHP-Parser/
 [2]: https://github.com/nikic
 [3]: https://github.com/nikic