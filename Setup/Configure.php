<?php

namespace Gisue\Setup;

class Configure
{
    public static function getDatabase()
    {
        return [
			"driver" => "mysql",
			"server" => "localhost",
			"username" => "root",
			"password" => "t",
			"dbname" => "world"
        ];
    }
}