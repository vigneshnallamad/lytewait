<?php

namespace Gisue\System;

class Chain extends Object
{
	public $isRoute = false;
	public $isView = false;

    function __construct()
    {
    	parent::__construct();
    }
    
    public function setRouting($var)
    {
    	$this->isRoute = $var;
    }
    
    public function setDisplayView($var)
    {
    	$this->isView = $var;
    }
    
    public function startRouting($app)
    {
    	$cls = $app->http->class;
    	$func = $app->http->function;
    	
    	if ($this->isRoute) {    		
	    	$route = 'Gisue\\Route\\'.$cls.'Route';
	    	$routeRawResult = (new $route($app))->start();
	    	if ($routeRawResult['status'] == false) {
	    		$app->sendError(400, 'Route not found', ["raw" => []]);
	    	}
	    	$routeResult = $routeRawResult['raw'];
	    	if (isset($routeResult['Filter'])) {
	    		foreach ($routeResult['Filter'] as $filter) {
	    			/*if (!$app->isClassExists('Filter', $filter, true)) {
		    			$app->sendError(400, 'Filter not found', ["filter" => $filter]);
		    		}*/
	    			list($filterClass, $filterAction) = [$filter['class'], $filter['action']];
	    			$fo = new $filterClass($app);
	    			$fo->$filterAction($routeRawResult);
	    		}
	    	}
	    	if (isset($routeResult['Controller'])) {
	    		$controller = $routeResult['Controller']['class'];
	    		$action = $routeResult['Controller']['action'];
	    		$arguments = array_slice($routeRawResult['parameters'],$routeRawResult['index']+1);
	    		call_user_func_array(array(new $controller($app), $action), $arguments);
	    		/*foreach ($routeResult['Controller'] as $controller => $action) {
	    			if (!$app->isClassExists('Controller', $controller, true)) {
		    			$app->sendError(400, 'Controller not found', ["controller" => $controller]);
		    		}
	    		}*/
	    	}
	    	if (isset($routeResult['View'])) {
	    		$view = $routeResult['View']['class'];
	    		$action = $routeResult['View']['action'];
	    		(new $view($app))->$action();
	    		/*foreach ($routeResult['View'] as $view => $action) {
	    			if (!$app->isClassExists('View', $view, true)) {
		    			$app->sendError(400, 'View not found', ["view" => $view]);
		    		}
	    			(new $view($app))->$action();
	    		}*/
	    	}
    	} else {
    		if (!$app->isClassExists('Controller', $cls)) {
    			$app->sendError(400, 'Controller not found', ["controller" => $cls.'Controller']);
    		}
    		$controller = 'Gisue\\Controller\\'.$cls.'Controller';
    		(new $controller($app))->$func();
	    	if ($this->isView) {
    			if (!$app->isClassExists('View', $cls)) {
	    			$app->sendError(400, 'View not found', ["view" => $cls.'View']);
	    		}
	    		$view = 'Gisue\\View\\'.$cls.'View';
	    		(new $view($app))->$func();
	    	}
    	}
    }
}