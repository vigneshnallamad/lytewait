<?php

namespace Gisue\System;

class Database extends Object
{
    public $driver;
    public $server;
    public $username;
    public $password;
    public $dbname;
    public $conn;
    
    function __construct()
    {
    	parent::__construct();
    }

    public function setConfig($dbconfig) {
        $this->driver = (String) $dbconfig['driver'];
        $this->server = (String) $dbconfig['server'];
        $this->username = (String) $dbconfig['username'];
        $this->password = (String) $dbconfig['password'];
        $this->dbname = (String) $dbconfig['dbname'];
    }
    
    public function setConfigFromFile($var)
    {
    	$string_config = file_get_contents($var);
    	$config = json_decode($string_config, true);
    	$this->setConfig($config['database']);
    }

    public function getConnection()
    {
        if(is_null($this->conn)) {
            $this->conn = new mysqli(
                $this->server,
                $this->username,
                $this->password,
                $this->dbname
            );
        }
		if ($conn->connect_error) {
			(new Response())->sendError(500, 'Server Internal Problem',
				[
					'65' => $conn->connect_error
				]);
		}
        return $this->conn;
    }
}