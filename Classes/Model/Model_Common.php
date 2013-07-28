<?php
class Model_Common
{
	/**
	 * @var Sys_Core
	 */
	protected $core;

	public function __construct($core)
	{
		$this->core = $core;
	}
}
