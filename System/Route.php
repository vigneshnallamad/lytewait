<?php

namespace Gisue\System;

class Route extends Framework
{
	public $route = [];

	function __construct($app)
	{
		parent::__construct($app);
		$this->className = 'route';
	}
	
    public function start()
    {
	    $request = [
	    		"url" => $this->app->http->req->requestUri,
	    		"method" => $this->app->http->req->requestMethod,
	    		"index" => $this->app->http->actionPos
	    ];
	    $request['parameters'] = explode('/', $request['url']);
	    return $this->checkPattern($this->route, $request);
    }
    
    public function checkPattern($route, $request)
    {
    	$index = $request['index'];
    	foreach ($route as $urlBundle) {
    		if($this->rotatePattern($urlBundle, $index, $request) == true) {
    			return [
    					"status" => true,
    					"index" => $index,
    					"parameters" => $request['parameters'],
    					"raw" =>$urlBundle
    			];
    		}
    	}
    	return ["status" => false];
    }

    public function rotatePattern($urlBundle, $index, $request)
    {
    	if (($urlBundle['action'] == $request['parameters'][$index])
    			&& ($urlBundle['method'] == $request['method'])){
    		$conditionSet = $this->parsingUrl($urlBundle['url']);
    		if ((count($request['parameters'])-($request["index"]+1)) != count($conditionSet)) {
    			return false;
    		}
    		for ($i = $index+1; $i < count($request['parameters']) ; $i++) {
    			if ($conditionSet[$i - ($index + 1)]['type'] == 'array' && in_array($request['parameters'][$i], $conditionSet[$i - ($index + 1)]["values"])) {
    				continue;
    			} else if ($conditionSet[$i - ($index + 1)]['type'] == 'number' && is_numeric($request['parameters'][$i])) {
    				continue;
    			} else if ($conditionSet[$i - ($index + 1)]['type'] == 'string') {
    				continue;
    			} else {
    				return false;
    			}
    		}
    		return true;
    	}
    }
    
    public function parsingUrl ($strUrl)
    {
    	$result = preg_replace("([{/}])", " ", $strUrl);
    	$result = trim($result);
    	$urlArr = explode('   ', $result);
    	$url = [];
    	foreach ($urlArr as $urlPart) {
    		$position = strpos($urlPart, ':');
    		$subUrl = substr($urlPart,$position);
    		if ($subUrl == $urlPart) {
    			$url[] = [
    					"name" => $urlPart,
    					"type" => "string"
    			];
    		} else if ($subUrl == ":number") {
    			$name = str_replace($subUrl, "", $urlPart);
    			$url[] = [
    					"name" => $name,
    					"type" => "number"
    			];
    		} else {
    			$parseUrl1 = preg_replace("([:(|)])", " ", $subUrl);
    			$parseUrl = trim($parseUrl1);
    			$urlArr = explode(' ', $parseUrl);
    			$name = str_replace($subUrl, "", $urlPart);
    			$url[] = [
    					"name" => $name,
    					"type" => "array",
    					"values" => $urlArr
    			];
    		}
    	}
    	return $url;
    }
}