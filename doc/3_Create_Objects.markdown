Creating objects
================

It is also possible to create objects from scratch.
But this makes sense only for simple objects of course, since you don't want to create statement arrays for method bodies manually.

Here an example:

```php
	$newClassFileObject = new Tx_PhpParser_Domain_Model_File;
	$newClass = new Tx_PhpParser_Domain_Model_Class('MyNewClass);
	$newClass->setDescription("This is a class created\nfrom scratch")
		->setTag('author','John Doe');
	$newClassFileObject->addClass($newClass);

	$PHPCode = PrinterService->renderClassObject($newClassFileObject);

```

See the [function tests][1] for more examples.

[Stand alone usage][2]

[1]: https://github.com/nicodh/php_parser_api/blob/master/Tests/Function/BuildObjects.php
[2]: https://github.com/nicodh/php_parser_api/tree/master/doc/4_Standalone_Usage.markdown
