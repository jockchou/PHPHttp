<?php

/**
 * JockChou (http://jockchou.github.io)
 *
 * @link      https://github.com/jockchou
 * @copyright Copyright (c) 2016 JockChou
 * @license   https://github.com/jockchou/PHPHttp/blob/master/LICENSE (Apache License)
 */
interface ParserInterface
{

    /**
     * @param $input
     * @param null $context
     * @return mixed
     */
    public function parseHttp($input, $context = null);
}