Limitations
===========

At the moment there is only a limited support for "first level" statements in PHP files.
The API can not handle statements outside of classes or functions except include statements.

So if you have something like this in a file:

```php
if($SOME_CONDITION) {
	require('somefile.php');
}
```

or

```php

define(FOO,'BAR');

class MyClassName {

}

```

It would throw an exception when traversing the statements. This is, because there is no
possibility to handle such stuff in an object oriented style.

Another limitation is, that the order of statemts might change. For example if you have something like:

```php

class MyClass {


}

require ('SomeFile.php');

class MyOtherClass {

}

```
This would result in
```php

class MyClass {


}

class MyOtherClass {

}

require ('SomeFile.php');

```

Since there is only a distinction between preIncludes and postIncludes. Which means, before or after declaring classes in a file.

Traits and Mixins are also not supported yet, (but probably will be in future).
