<?php
/**
 * Class Controller_Common
 */
class Controller_Common
{
	/**
	 * @var Sys_Core
	 */
	protected $core;
	/**
	 * @var Template_Common
	 */
	protected $template;

	/**
	 * @param $core
	 */
	public function init($core)
	{
		$this->core = $core;
	}

	/**
	 * @param Template_Common $template
	 */
	protected function setTemplate(Template_Common $template)
	{
		$this->template = $template;
	}

}


