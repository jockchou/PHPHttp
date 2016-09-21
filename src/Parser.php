<?php

/**
 * JockChou (http://jockchou.github.io)
 *
 * @link      https://github.com/jockchou
 * @copyright Copyright (c) 2016 JockChou
 * @license   https://github.com/jockchou/PHPHttp/blob/master/LICENSE (Apache License)
 */
//http://www.ietf.org/rfc/rfc2616.txt
class Parser implements ParserInterface
{

    /**
     * @param $input
     * @param null $context
     * @return mixed
     */
    public function parseHttp($input, $context = null)
    {
        $headers = [];
        $cookie = [];
        $boundary = '';
        $server = [];
        $get = [];
        $post = [];
        $request = [];
        $files = [];

        list($headerContent, $bodyContent) = explode('\r\n\r\n', $input);
        $headerLines = explode('\r\n', $headerContent);
        list($method, $uri, $protocolVersion) = explode('\r\n', $headerLines[0]);

        $server['SERVER_PROTOCOL'] = $protocolVersion;
        $server['REQUEST_URI'] = $uri;
        $server['REQUEST_METHOD'] = $method;
        $server['QUERY_STRING'] = parse_url($uri, PHP_URL_QUERY);
        if ($server['QUERY_STRING']) {
            parse_str($server['QUERY_STRING'], $get);
        } else {
            $server['QUERY_STRING'] = '';
        }
        $server['CONTENT_TYPE'] = '';

        //解析头部
        foreach ($headerLines as $lineNo => $headerLine) {
            if ($lineNo === 0 || empty($headerLine)) {
                continue;
            }

            list($headerName, $headerValue) = explode(':', $headerLine, 2);
            $headerValue = ltrim($headerValue);
            $headers[$headerName] = $headerValue;

            switch (strtolower($headerName)) {
                case 'host':
                    $server['HTTP_HOST'] = $headerValue;
                    //[HTTP_HOST] => demo.jockchou.com:8080
                    $tmp = explode(':', $headerValue);
                    $server['SERVER_NAME'] = $tmp[0];
                    if (isset($tmp[1])) {
                        $server['SERVER_PORT'] = $tmp[1];
                    }
                    break;
                case 'cookie':
                    $server['HTTP_COOKIE'] = $headerValue;
                    $cookie = explode('; ', $headerValue);
                    break;
                case 'content-type':
                    if (!preg_match('/(multipart\/[\w-]+); boundary\=(\S+)/', $headerValue, $match)) {
                        $server['CONTENT_TYPE'] = $headerValue;
                    } else {
                        $server['CONTENT_TYPE'] = $match[1];
                        $boundary = '--' . $match[2];
                    }
                    break;
                default:
                    $serverKeyName = 'HTTP_' . str_replace("-", "_", strtoupper($headerName));
                    $server[$serverKeyName] = $headerValue;
            }
        }

        //解析body
        if (strtoupper($method) === 'POST') {
            if ($server['CONTENT_TYPE'] === 'multipart/form-data') {
                $files = $this->parseUploadFiles($bodyContent, $boundary);
            } else {
                parse_str($bodyContent, $post);
            }
        }

        return [
            '_GET' => $get,
            '_POST' => $post,
            '_COOKIE' => $cookie,
            '_SERVER' => $server,
            '_FILES' => $files,
            '_REQUEST' => $request,
            '_HEADERS' => $headers,
            '_BOUNDARY' => $boundary,
        ];
    }

    /**
     * @param $bodyContent
     * @param $boundary
     */
    public function parseUploadFiles($bodyContent, $boundary)
    {

    }
}