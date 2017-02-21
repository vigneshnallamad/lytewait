<?php

namespace Gisue\System;

class Collection extends Object
{
    public $db;

    function __construct()
    {
    	parent::__construct();
    }

    public function setConfig($dbconfig)
    {
        $this->db = new Database();
        $this->db->setConfig($dbconfig);
    }
}