<?php
/**
 * JockChou (http://jockchou.github.io)
 *
 * @link      https://github.com/jockchou
 * @copyright Copyright (c) 2016 JockChou
 * @license   https://github.com/jockchou/PHPHttp/blob/master/LICENSE (Apache License)
 */

// Set timezone
date_default_timezone_set('PRC');

$autoloader = require dirname(__DIR__) . '/vendor/autoload.php';

// Register test classes
$autoloader->addPsr4('PHPHttp\Tests\\', __DIR__);