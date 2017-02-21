<?php

namespace {
    error_reporting(E_ALL);
    ini_set('display_errors', true);

    function __autoload($class) {
        $class = str_replace('\\', '/', $class);
        $class = preg_replace('/^Gisue/', 'src', $class);
        require_once $class.'.php';
    }

    set_include_path(
        realpath(dirname(__FILE__).'/../').PATH_SEPARATOR.
        realpath(dirname(__FILE__).'/Gisue')
    );
}


namespace Gisue {

	use Gisue\System\Application;
	use Gisue\System\Collection;
	use Gisue\System\Chain;
	use Gisue\System\Http;
	use Gisue\Setup\Configure;

	function loader() {
		try {
			$app = new Application();
			$app->set("http", function(){
				$http = new Http();
				/*
				 * Position of Class and Function, Http to Handle Request and Response
				 */
				$http->setUrlParsingPosition(Application::SECOND);
				return $http;
			});
			$app->set("collection", function(){
				$collection = new Collection();
				/*
				 * To Handle Database, Session, Cookies, Logger, Json etc.
				 */
				$collection->setConfig(Configure::getDatabase());
				return $collection;
			});
			$app->set("chain", function(){
				$chain = new Chain();
				$chain->setRouting(true);
				$chain->setDisplayView(true);
				/*
				 * To Handle Filter, Route, Controller, Model, View etc.
				 */
				return $chain;
			});
			$app->set("namespace", function(){
					return [
						"Controller"    => "Gisue/Controller",
						"Filter"    => "Gisue/Filter",
						"Model"    => "Gisue/Model",
						"Route"    => "Gisue/Route",
						"View"    => "Gisue/View"
					];
				}
			);
			$app->run();
		} catch (\Exception $e) {
			echo "error". $e->getMessage(); 
		}
	}
	
	loader();
}