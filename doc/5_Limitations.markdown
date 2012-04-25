Limitations
===========

The order of statemts might change. For example if you have something like:

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

Since there is only a distinction between preStatements and postStatements. Which means, before or after declaring classes in a file.

Traits and Mixins are also not supported yet, (but probably will be in future).
