<?php
class Template_Common
{
	/**
	 * @var Sys_Core
	 */
	protected $core;
	public $www;

	public function init($core)
	{
		$this->core = $core;
		$this->www = $core->misc->getWWW();
	}

	public function render()
	{
		//init twig
		require_once 'Twig/lib/Twig/Autoloader.php';
		$loader = new Twig_Loader_Filesystem('web/templates');
		$twig = new Twig_Environment($loader, array(
			'cache' => 'Caches/Twig',
			'auto_reload' => $this->core->config->isDev,
		));

		//init tpl
		$templateFile = str_replace(array('Template_', '_'), array('', '/'), get_class($this)) . '.twig';
		$subFolder = $this->core->misc->is_mobile() ? 'mobile' : 'standard';
		$template = $twig->loadTemplate($subFolder . '/' . $templateFile);

		//set vars
		$templateVars = array();
		foreach ($this as $name => $value) {
			$templateVars[$name] = $value;
		}

		//render
		echo $template->render($templateVars);
	}

	private function renderStandardHeader()
	{
		?>

		<!doctype html>
		<html>
		<head>
			<meta charset="utf-8">
			<title>Tasker</title>
			<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"/>
			<link rel="stylesheet" href="css/standard.css"/>
		</head>
		<body>
		<table border="0" style="width: 100%;">
			<tr>
				<td style="width: 100%;">
					<fieldset>
						<legend>Сообщение системы</legend>
						<? $flash = $this->core->misc->getFlash(); ?>
						<? if ($flash): ?>
							<?= $flash ?>
						<? else: ?>
							<span>Сообщений от системы нет</span>
						<?endif; ?>
					</fieldset>
				</td>
				<td>
					<fieldset>
						<legend>Пользователь</legend>
						<? if ($this->core->user): ?>
							<table>
								<tr>
									<td>
										<?= $this->core->user->name; ?>
									</td>
									<td>
										<form action="<?= $this->www ?>" method="post">
											<input type="hidden" name="action" value="User-logout">
											<input type="submit" value="Выйти">
										</form>
									</td>
								</tr>
							</table>


						<? else: ?>
							Аноним
						<?endif; ?>
					</fieldset>
				</td>
			</tr>
		</table>

	<?
	}

private function renderMobileHeader()
{
	?>

	<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Tasker</title>
		<link rel="stylesheet" href="css/mobile.css"/>
	</head>
<body>
	<table border="0" style="width: 100%;">
		<tr>
			<td style="width: 100%;">
				<fieldset>
					<legend>Сообщение системы</legend>
					<? $flash = $this->core->misc->getFlash(); ?>
					<? if (count($flash)): ?>
						<? foreach ($flash as $data): ?>
							<? if ($data['status'] == Sys_Misc::FLASH_OK): ?>
								<div style="padding:3px;background-color: green;color: white">
									<?= $data['message'] ?>
								</div>
							<? else: ?>
								<div style="padding:3px;background-color: red;color: white">
									<?= $data['message'] ?>
								</div>
							<?endif; ?>
						<? endforeach; ?>
					<? else: ?>

						<div style="padding:3px;">
							Сообщений от системы нет
						</div>
					<?endif; ?>
				</fieldset>
			</td>
			<td>
				<fieldset>
					<legend>Пользователь</legend>
					<div style="padding:3px;">
						<? if ($this->core->user): ?>
							<?= $this->core->user->name; ?>
						<? else: ?>
							Аноним
						<?endif; ?>
					</div>
				</fieldset>
			</td>
			<td>
				<form action="<?= $this->www ?>" method="post">
					<input type="hidden" name="action" value="User-logout">
					<input type="submit" value="Выйти" style="height:70px">
				</form>
			</td>
		</tr>
	</table>


<?
}

	public function renderFooter()
	{

		if ($this->core->misc->is_mobile()) {
			$this->renderMobileFooter();
		} else {
			$this->renderStandardFooter();
		}

	}

public function renderStandardFooter()
{

	?>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script src="js/standard.js"></script>
</body>
</html>

<?

}

	public function renderMobileFooter()
	{

		?>
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="js/mobile.js"></script>
		</body>
		</html>

	<?

	}

}
