Inspecting objects
==================

The API provides methods comparable to the PHP Reflection. but it is not neccessary to load the classes.

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
	$fileObject->getFirstClass()->getMethod('foo')->getParameters()
```

Besides that, the docComment is also parsed, so there is a posiibility to get (and set) annotations:

```php
	$classObject->addTag('package','myPackage')->addTag('author','John Doe');
	$methodObject->getTag('return');
	$classObject->setDescription('This is the description that goes into the docComment');
```

See some examples in the [parser unit tests][2]

[Modify Objects][1]

[1]: https://github.com/nicodh/php_parser_api/tree/master/doc/2_Modify_Objects.markdown
[2]: https://github.com/nicodh/php_parser_api/blob/master/Tests/Unit/ParserTest.php