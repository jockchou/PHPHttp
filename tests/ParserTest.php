<?php

/**
 * JockChou (http://jockchou.github.io)
 *
 * @link      https://github.com/jockchou
 * @copyright Copyright (c) 2016 JockChou
 * @license   https://github.com/jockchou/PHPHttp/blob/master/LICENSE (Apache License)
 */

namespace PHPHttp\Tests;

use PHPHttp\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function testParseHeader()
    {
        $parser = new Parser();
        $content = file_get_contents(dirname(__FILE__) . "/data/testParseHeader.txt");
        $httpVars = $parser->parseHttp($content);
        $this->assertEquals(true, is_array($httpVars));
        $this->assertEquals("www.phpunit.cn", $httpVars['_HEADERS']['Host']);
    }
}