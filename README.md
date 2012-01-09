Class Grapher
=============

This code is distributed under the MIT license.

This application will generate a basic class diagram in GraphViz DOT format from
the PHP files found in the path given as parameter. This code does not use PHP 
reflection so that there is no need to actually instanciate the classes that will
be shown in the diagram.

Installation
------------

#### Download composer

See http://packagist.org/

You have to put the composer.phar file in the root directory of the project.

#### Install the vendors

```
./composer.phar install
```

Usage
-----

Assumed you have GraphViz installed you can run the following command to generate
a class diagram of the class grapher:

```
php grapher.php lazyguy:graph src/ | dot -T png | display
```
