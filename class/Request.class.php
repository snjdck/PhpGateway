<?php
class Request
{
	public $op;
	public $data;

	function __construct($op, $data)
	{
		$this->op = $op;
		$this->data = $data;
	}
}