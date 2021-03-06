PHP Parser API
==============

This project provides an API for the [PHPParser][1] written by [nikic][2].
It's implemented as a TYPO3 extension but can be easily used as a stand-alone library.
The PHP Parser is included as sub module. Actually it's a [fork][6] of the Parser of [nikic][2],
since we needed more support for whitespaces and single line comments which was implemented by [Tom Maroschik][7].

Documentation can be found in the [docs][4] directory.

There is also a [PhpDoc][5] available.

***Note: This is still in alpha state, so the API is subject to change.***

What is this for?
-----------------

This library provides an API to parse, "understand", manipulate and rewrite PHP classes, functions, methods etc.

For example:
```php
<?php
$phpFileObject = $ParserService->parseFile('path/To/File.php');
$classObjects = $phpFileObject->getClasses();

foreach($classObjects as $classObject) {
	if($classObject->hasMethod('foo')) {
		$classObject->getMethod('foo')->setName('bar');
	}
}

$PHPCode = $PrinterService->renderFileObject($phpFileObject);
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
Currently the printer tries to render TYPO3 CGL compliant code.
The library also provides methods to add, remove or change annotations in the doc comments.
For example it adds @param tags in methods (if they are missing) according to the parameter type hints.

Have a look at the Unit and Function tests in the [Tests][3] directory to see some examples or read the [documentation][4]

But there are also some [limitations][8] which we might overcome in the future...


 [1]: https://github.com/nikic/PHP-Parser/
 [2]: https://github.com/nikic
 [3]: https://github.com/nicodh/php_parser_api/tree/master/Tests/
 [4]: https://github.com/nicodh/php_parser_api/tree/master/doc/1_Inspect_Objects.markdown
 [5]: http://nicodh.github.com/php_parser_api/phpdoc/packages/PhpParserApi.html
 [6]: https://github.com/tmaroschik/PHP-Parser
 [7]: https://github.com/tmaroschik
 [8]: https://github.com/nicodh/php_parser_api/tree/master/doc/5_Limitations.markdown