Introduction
============

This project is a wrapper or facade for a fork of the PHP Parser written by nikic

What is this for?
-----------------

It provides an API to parse, "understand", manipulate and rewrite PHP classes, functions, methods etc.

For example:

$phpFileObject = ParserService->parseFile('pathToFile');
$classObjects = $phpFileObject->getClasses();

foreach($classObjects as $classObject) {
	if($classObject->hasMethod('foo')) {
		$classObject->getMethod('foo')->setName('newName');
	}
}

$newCode = PrinterService->render($phpFileObject);

What else can it do?
--------------------


Since the original Parser didn't care for whitespaces and comments.
