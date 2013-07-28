<?php
/**
 * Class Sys_Core
 */
class Sys_Core
{
	/**
	 * @var Config
	 */
	public $config;
	/**
	 * @var Sys_Mysql
	 */
	public $db;
	/**
	 * @var Sys_Misc
	 */
	public $misc;
	/**
	 * @var
	 */
	private $controllerName;
	/**
	 * @var Entity_User
	 */
	public $user = false;
	/**
	 * @var
	 */
	private $controllerAction;
	/**
	 * @var string
	 */
	private $defaultControllerName = 'User';
	/**
	 * @var string
	 */
	private $defaultControllerAction = 'showLogin';

	public $memo = array();

	/**
	 *
	 */
	public function __construct()
	{
		$this->init();
		$this->doit();
	}

	/**
	 *
	 */
	private function init()
	{
		require_once('Config.php');
		$this->config = new Config();

		$this->db = new Sys_Mysql();
		$this->db->init($this);

		$this->misc = new Sys_Misc();
	}

	/**
	 *
	 */
	private function doit()
	{
		$this->getUser();
		$this->processRoute();
		$this->processAction();
	}

	private function getUser()
	{
		$userModel = new Model_User($this);
		$user = $userModel->getUser();
		$this->user = $user;
	}

	private function processRoute()
	{
		$action = '';
		if (isset($_REQUEST['action'])) {
			$action = $_REQUEST['action'];
		}
		list($this->controllerName, $this->controllerAction) = $this->getAction($action);
	}

	/**
	 *
	 */
	private function processAction()
	{
		$controllerClassName = 'Controller_' . $this->controllerName;

		$controller = new $controllerClassName();

		$actionName = $this->controllerAction . "_action";

		/**
		 * @var Controller_Common $controller
		 */
		$controller->init($this);
		$controller->$actionName();

	}

	/**
	 * @param $action
	 * @return array
	 */
	private function getAction($action)
	{
//here must be db route request
		if (($action && $this->user) || in_array($action, array('User-register', 'User-login'))) {
			return explode('-', $action);
		} elseif (!$action && $this->user) {
			$this->misc->redirect('action=Task-showTaskList');
		} else {
			return array(
				$this->defaultControllerName,
				$this->defaultControllerAction
			);
		}
	}

}


