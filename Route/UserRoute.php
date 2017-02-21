<?php

namespace Gisue\Route;

use Gisue\System\Route;

class UserRoute extends Route
{
	public $route = [
    	[
    		"url" => "/{knl:(op|ip|ewe)}/{id:number}/{str}/{knl:(op|ip|ewe)}",
    		"action" => "list",
    		"method" => "GET",
    		"Filter" => [
    			[
    				"class" => "\\Gisue\\Filter\\UserFilter",
    				"action" => "isAdmin"
    			],
    			[
    				"class" => "\\Gisue\\Filter\\UserFilter",
    				"action" => "list"
    			],
    		],
    		"Controller" => [
    			"class" => "\\Gisue\\Controller\\UserController",
    			"action" => "listing"
    		],
    		"View" => [
    			"class" => "\\Gisue\\View\\UserView",
    			"action" => "list"
    		]
    	],
    	[
    		"url" => "/{id:number}/{str}/{knl:(op|ip|ewe)}",
    		"action" => "list",
    		"method" => "POST",
    		"Filter" => [
    				"UserFilter" => "userlist"
    		],
    		"Controller" => ["UserController", "list"],
    		"View" => ["UserView", "list"]
    	]
    ];
}