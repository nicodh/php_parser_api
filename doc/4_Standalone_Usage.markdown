Stand alone usage
=================

If you want to use the API not as an TYPO3 extension you can use it also without TYPO3 of course.

The usage is straight forward:

```php
<?php
	require_once($absolutePath . 'php_parser_api/Classes/AutoLoader.php');
	Tx_PhpParser_Utility_AutoLoader::register();

	$ParserService = new Tx_PhpParser_Service_Parser();
	$PrinterService = new Tx_PhpParser_Service_Printer();
```

Credits go to [nikic][1] for providing the php-parser and to [Tom Maroschik][2] for the additional improvements to support whitespaces and comments.

 [1]: https://github.com/nikic
 [2]: https://github.com/tmaroschik