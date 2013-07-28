<?php
class Model_User extends Model_Common
{
	/**
	 * @var Sys_Core
	 */
	protected $core;


	public function register()
	{
		$userName = $_REQUEST['name'];
		$password = $_REQUEST['pwd'];
		if ($this->isUserNameExists($userName)) {
			$this->core->misc->setFlash('Регистрация неудачна, имя "' . $userName . '" уже занято', Sys_Misc::FLASH_BAD);
			$this->core->misc->redirect();
		} else {
			$user = new Entity_User();
			$user->name = $userName;
			$user->password = $this->hashPassword($password);
			$insertedId = $this->core->db->insert($user, 'user');
			if ($insertedId) {
				$user->id = $insertedId;
				$this->core->misc->setFlash('Вы зарегистрированы. Вы вошли в систему.', Sys_Misc::FLASH_OK);
				$this->setUser($user);
				$this->core->misc->redirect('action=Task-showTaskList');
			} else {
				$this->core->misc->setFlash('Регистрация неудачна, системная ошибка. Обратитсь на lllewik@gmail.com или по скайпу lewik01', Sys_Misc::FLASH_BAD);
			}
		}
	}

	public function login()
	{
		$userName = $_REQUEST['name'];
		$password = $_REQUEST['pwd'];
		/**
		 * @var Entity_User $user
		 */
		$user = $this->checkUserPassword($userName, $password);
		if ($user) {
			$this->setUser($user);
		}
	}

	public function logout()
	{
		session_destroy();
		$this->core->misc->redirect();
	}

	public function hashPassword($password)
	{
		$hash = md5($password . 'ololo' . $password . ';№:%');
		return $hash;
	}

	public function isUserNameExists($userName)
	{
		$user = $this->core->db->get(new Entity_User(), 'SELECT id, name, password FROM user WHERE name = "' . $userName . '"');
		return !!count($user);
	}

	public function getUser()
	{
		if (isset($_SESSION['userId'])) {
			$userId = $_SESSION['userId'] + 0;
			$user = $this->core->db->get(new Entity_User(), 'SELECT id, name FROM user WHERE id = ' . $userId);
			list($user) = $user;
		} else {
			$user = false;
		}

		return $user;
	}

	public function setUser(Entity_User $user)
	{
		$this->core->user = $user;
		$_SESSION['userId'] = $user->id;
	}

	public function checkUserPassword($userName, $password)
	{
		$password = $this->hashPassword($password);
		$user = $this->core->db->get(new Entity_User(), 'SELECT id, name, password FROM user WHERE name = "' . $userName . '" AND password = "' . $password . '"');
		if (count($user)) {
			list($user) = $user;
		} else {
			$user = false;
		}
		return $user;
	}
}
