Class Grapher
=============

This code is distributed under the MIT license.

This application will generate a basic class diagram in GraphViz DOT format from
the PHP files found in the path given as parameter.

Installation
------------

Before using the grapher you need to install the vendors libraries:

```
./composer.phar install
```

Usage
-----

Assumed you have GraphViz installed you can run the following command to generate
a class diagram of the class grapher:

```
grapher lazyguy:graph src/ | dot -T png | display
```
