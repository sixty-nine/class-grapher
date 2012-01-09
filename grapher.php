#!/usr/bin/env php
<?php

require 'vendor/.composer/autoload.php';

use LazyGuy\ClassGrapher\ClassGrapherApp;

$app = new ClassGrapherApp();
$app->run();
