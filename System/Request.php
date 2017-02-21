<?php

namespace Gisue\System;

class Request extends Object
{
    public $httpUserAgent;
    public $redirectUrl;
    public $requestMethod;
    public $requestUri;
    public $urlParts;

    function __construct()
    {
    	parent::__construct();
    	list($this->httpUserAgent,$this->redirectUrl,$this->requestMethod,$this->requestUri) = [
    			$_SERVER['HTTP_USER_AGENT'],
    			$_SERVER['REDIRECT_URL'],
    			$_SERVER['REQUEST_METHOD'],
    			$_SERVER['REQUEST_URI']
    	];
    	$this->urlParts = explode("/",$this->redirectUrl);
    }
}