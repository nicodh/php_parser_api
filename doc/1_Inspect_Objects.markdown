Inspecting objects
==================

The API provides methods comparable to the PHP Reflection but without loading the classes.

Currently these objects are available:

 * File
 * Namespace
 * Class
 * ClassMethods
 * ClassProperties
 * Functions

File, Namespace and Class inherit from Container, which means they can contain other objects.

So we can do something like:
```php
<?php
	$fileObject->getFirstClass()->getMethod('foo')->getParameters()
```

Besides that, the docComment is also parsed, so there is a posiibility to get (and set) annotations:

```php
<?php
	$classObject->addTag('package','myPackage')->addTag('author','John Doe');
	$methodObject->getTag('return');
	$classObject->setDescription('This is the description that goes into the docComment');
```

See some examples in the [parser unit tests][2]

Documentation:
 * [Modify Objects][1]
 * [Create Objects][3]
 * [Stand alone usage][4]
 * [Limitations][4]

[1]: https://github.com/nicodh/php_parser_api/tree/master/doc/2_Modify_Objects.markdown
[2]: https://github.com/nicodh/php_parser_api/blob/master/Tests/Unit/ParserTest.php
[3]: https://github.com/nicodh/php_parser_api/tree/master/doc/3_Create_Objects.markdown
[4]: https://github.com/nicodh/php_parser_api/tree/master/doc/4_Standalone_Usage.markdown
[5]: https://github.com/nicodh/php_parser_api/tree/master/doc/5_Limitations.markdown