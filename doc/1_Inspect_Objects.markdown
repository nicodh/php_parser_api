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