<?php
class Template_Login extends Template_Common
{
	public $tasks = array();


	private function renderStandard()
	{
		$this->renderHeader();

		?>
		<h2>Логин</h2>
		<form action="<?= $this->www ?>" method="post">
			<input type="hidden" name="action" value="User-login">
			<table>
				<tbody>
				<tr>
					<td><input type="text" name="name" placeholder="Логин" value=""></td>
				</tr>
				<tr>
					<td><input type="password" name="pwd" placeholder="Пароль"></td>
				</tr>
				<tr>
					<td><input type="submit" value="Войти"></td>
				</tr>
				</tbody>
			</table>
		</form>
		<h2>Регистрация</h2>
		<form action="<?= $this->www ?>" method="post">
			<input type="hidden" name="action" value="User-register">
			<table>
				<tbody>
				<tr>
					<td><input type="text" name="name" placeholder="Логин" value=""></td>
				</tr>
				<tr>
					<td><input type="password" name="pwd" placeholder="Пароль"></td>
				</tr>
				<tr>
					<td><input type="submit" value="Зарегистрироваться"></td>
				</tr>
				</tbody>
			</table>
		</form>
		<?

		$this->renderFooter();
	}


}


