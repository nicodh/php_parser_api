Modifying objects
==================

Other than the PHP Reflection this API also provides the possibility to modify objects and rewrite the PHP code (based on the PrettyPrinter of the php-parser[1]).

So you can do something like:
```php
<?php
	$methodObject->setName('bar');
	$methodObject->setModifier('private');
	$classObject->addMethod($someMethodObject);

```

Be aware that there is often a distinction between setProperty and addProperty. The addProperty functions will throw exceptions, if some non allowed operation happens.
For example adding a method with a name that already exists. The setProperty method will replace existing properties.

The same with modifiers: addModifier('private') will throw an exception if the object has a modifier 'protected' or 'public',
since both are not allowed at the same time. The method setModifier cares about that and replaces the current access modifier.

[1]: https://github.com/nikic/PHP-Parser/