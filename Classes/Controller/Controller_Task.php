<?php
class Controller_Task extends Controller_Common
{
	/**
	 * @var Template_TaskList $this->template
	 */
	var $template;

	public function showTaskList_action()
	{
		$tagModel = new Model_Tag($this->core);

		if (isset($_REQUEST['taskByTag']) && $_REQUEST['taskByTag'] != '') {
			$tagModel->setTaskListTag($_REQUEST['taskByTag']);
		}

		if (isset($_REQUEST['createNewTag']) && $_REQUEST['createNewTag'] != '') {
			$newTag = new Entity_Tag();
			$newTag->name = $_REQUEST['createNewTag'];
			$newTag->user_id = $this->core->user->id;
			$this->core->db->insert($newTag, 'tag');
		}

		if ($tagModel->getTaskListTag()) {
			$additionalClause = 'AND id in (SELECT task_id FROM tag_to_task WHERE tag_id = ' . $tagModel->getTaskListTag() . ')';
		} else {
			$additionalClause = '';
		}

		$sql = 'SELECT id, title, text, user_id FROM task WHERE user_id = ' . $this->core->user->id . ' ' . $additionalClause . ' ORDER BY id DESC';
		$tasks = $this->core->db->get(new Entity_Task(), $sql);

		$tasksWithTags = array();

		foreach ($tasks as $task) {

			$taskWithTags = new Entity_TaskAndTags();
			$taskWithTags->id = $task->id;
			$taskWithTags->title = $task->title;
			$taskWithTags->text = $task->text;
			$taskWithTags->user_id = $task->user_id;
			$taskWithTags->tags = $tagModel->getTagsForTask($task->id);

			$tasksWithTags[] = $taskWithTags;
		}

		$this->setTemplate(new Template_TaskList());
		$this->template->init($this->core);
		$this->template->tags = $tagModel->getUserTags($this->core->user->id);
		$this->template->tasks = $tasksWithTags;
		$this->template->currentTag = $tagModel->getTaskListTag();
		$this->template->render();
	}

	public function edit_action()
	{
		$id = $_REQUEST['id'] + 0;
		list($task) = $this->core->db->get(new Entity_Task(), 'SELECT id, title, text, user_id FROM task WHERE id = ' . $id . ' AND user_id = ' . $this->core->user->id);

		foreach ($task as $name => $value) {
			if (isset($_REQUEST[$name])) {
				$task->$name = $_REQUEST[$name];
			}
		}

		$this->core->db->update($task, 'task');

		$tagModel = new Model_Tag($this->core);
		$tagModel->unlinkTagsFromTask($id);
		if (isset($_REQUEST['tag'])) {
			$tagModel->linkTagsToTask($id, $_REQUEST['tag']);
		}


		$this->core->misc->setFlash('Задание отредактировано', Sys_Misc::FLASH_OK);

		$this->core->misc->redirect('action=Task-showTaskList');
	}

	public function delete_action()
	{
		$id = $_REQUEST['id'] + 0;
		list($task) = $this->core->db->get(new Entity_Task(), 'SELECT id, title, text, user_id FROM task WHERE id = ' . $id . ' AND user_id = ' . $this->core->user->id);
		if ($task) {
			$this->core->db->delete($id, 'task');
		}


		$this->core->misc->setFlash('Задание удалено', Sys_Misc::FLASH_OK);
		$this->core->misc->redirect('action=Task-showTaskList');
	}

	public function create_action()
	{
		$task = new Entity_Task();
		$task->user_id = $this->core->user->id;

		$taskId = $this->core->db->insert($task, 'task');

		$tagModel = new Model_Tag($this->core);
		if ($tagModel->getTaskListTag())
			$tagModel->linkTagsToTask($taskId, array($tagModel->getTaskListTag()));

		$this->core->misc->setFlash('Задание создано', Sys_Misc::FLASH_OK);
		$this->core->misc->redirect('action=Task-showTaskList');
	}

}


