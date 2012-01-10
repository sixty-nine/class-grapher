Class Grapher
=============

This code is distributed under the MIT license.

This application will generate a basic class diagram in GraphViz DOT format from
the PHP files found in the path given as parameter.

This code does not use PHP reflection so that there is no need to actually instanciate
the classes that will be shown in the diagram. It means you can graph any set of PHP
files, even if there are missing dependencies.

The grapher supports namespaced PHP 5.3. However, to reduce the width of the rendered 
graph, the full namespaces are not shown in the diagram. This can easily be changed in
GraphVizBuilder::addNode method.

Installation
------------

#### Download composer

See http://packagist.org/

You have to put the composer.phar file in the root directory of the project.

```
cd project_dir
wget http://getcomposer.org/composer.phar
chmod +x composer.phar
```

#### Install the vendors

```
./composer.phar install
```

Usage
-----

Assumed you have GraphViz installed you can run the following command to generate
a class diagram of the class grapher code:

```
php grapher.php lazyguy:graph src/ | dot -T png | display
```

Running the tests
-----------------

```
phpunit -c src/LazyGuy/ClassGrapher/Tests/
```