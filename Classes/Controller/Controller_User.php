<?php
class Controller_User extends Controller_Common
{
	public function register_action()
	{
		$userModel = new Model_User($this->core);
		$userModel->register();
	}

	public function login_action()
	{
		$userModel = new Model_User($this->core);
		$userModel->login();
		if ($this->core->user) {
			$this->core->misc->setFlash('Вы вошли в систему', Sys_Misc::FLASH_OK);
			$this->core->misc->redirect('action=Task-showTaskList');
		} else {
			$this->core->misc->setFlash('Ошибка входа в систему, пара логин - пароль не найдена', Sys_Misc::FLASH_BAD);
			$this->core->misc->redirect();
		}
	}

	public function logout_action()
	{
		$userModel = new Model_User($this->core);
		$userModel->logout();
	}

	public function showLogin_action()
	{
		$this->setTemplate(new Template_Login());
		$this->template->init($this->core);
		$this->template->render();
	}
}


