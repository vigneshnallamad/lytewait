<?php 
namespace Gisue\System;

class Response extends Object
{
	public $status = true;
	public $text;
	public $raw_data;
	public $error = false;
	public $errorText;
	public $code = 200;
	
	public $http_response = array(
			100 =>  "Continue",
			200 => "OK",
			204 => "No Content",
			301 => "Moved Permanently",
			400 => "Bad Request",
			401 => "Unauthorised",
			404 => "Not Found",
			500 => "Internal Server Error"
	);

	function __construct() 
	{
		parent::__construct();
	}
	
	public function sendResponse()
	{
		if ($this->getCode() == null) {
			$this->setCode(200);
		}
		header("HTTP/1.1 ".$this->getCode()." ".$this->http_response[$this->getCode()]);
		if ($this->isError()) {
			echo json_encode(
				[
					'status' => false,
					'error' => $this->getError(),
					'raw' => $this->getRaw()
				]
			);
		} else {		
			echo json_encode(
				[
					'status' => true,
					'text' => $this->getText(),
					'raw' => $this->getRaw()
				]
			);
		}
		exit;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function getStatus()
	{
		return $this->status;
	}
	
	public function setCode($code)
	{
		$this->code = $code;
	}
	
	public function getCode()
	{
		return $this->code;
	}
	
	public function setText($text)
	{
		$this->text = $text;
	}

	public function getText()
	{
		return $this->text;
	}

	public function setRaw($raw)
	{
		$this->raw_data = $raw;
	}

	public function getRaw()
	{
		return $this->raw_data;
	}
	
	public function setError($err)
	{
		$this->error = true;
		$this->errorText = $err;
	}
	
	public function isError()
	{
		return $this->error;
	}
	
	public function getError()
	{
		return $this->errorText;
	}
	
	public function sendError($code, $error, $raw)
	{
		$this->setCode($code);
		$this->setError($error);
		$this->setRaw($raw);
		$this->sendResponse();
	}
}