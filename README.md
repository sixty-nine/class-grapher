Class Grapher [![Build Status](https://secure.travis-ci.org/sixty-nine/ClassGrapher.png)](http://travis-ci.org/sixty-nine/ClassGrapher)
=============

This code is distributed under the MIT license.

This application will generate a basic class diagram in GraphViz DOT format from
the PHP files found in the path given as parameter.

The goal of the project is not to get an exact and detailed UML view, but rather
to provide the programmer with a quick way to figure out how some code is structured.

The grapher does not use PHP reflection so that there is no need to actually instanciate
the classes that will be shown in the diagram. It means you can graph any set of PHP
files, even if there are missing dependencies.

The grapher supports namespaced PHP 5.3. However, to reduce the width of the rendered 
graph, the full namespaces are not shown in the diagram. This can easily be changed in
the GraphVizBuilder::addNode method.

Installation
------------

This code uses external components that will be installed with composer.

#### Download composer

See http://packagist.org/

You have to put the composer.phar file in the root directory of the project.

```
cd project_dir # The folder where you have put the ClassGrapher files
wget http://getcomposer.org/composer.phar
chmod +x composer.phar
```

#### Install the vendors

```
./composer.phar install
```

Usage
-----

Assumed you have ImageMagick installed you can run the following command to generate
a class diagram of the class grapher code:

```
php devtools graph src/ | dot -T png | display
```

Running the tests
-----------------

```
phpunit -c tests/
```