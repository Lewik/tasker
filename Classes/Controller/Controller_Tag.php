<?php
class Controller_Tag extends Controller_Common
{
	public function edit_action()
	{
		list($tag) = $this->core->db->get(new Entity_Tag(), 'SELECT id, name, user_id FROM tag WHERE id =' . $_REQUEST['tag'] . ' AND user_id = ' . $this->core->user->id);
		$tag->name = $_REQUEST['newName'];
		$this->core->db->update($tag, 'tag');
		$this->core->misc->setFlash('Тег отредактирован', Sys_Misc::FLASH_OK);
		$this->core->misc->redirect('action=Task-showTaskList');
	}

	public function delete_action()
	{
		list($tag) = $this->core->db->get(new Entity_Tag(), 'SELECT id, name, user_id FROM tag WHERE id =' . $_REQUEST['tag'] . ' AND user_id = ' . $this->core->user->id);
		$this->core->db->delete($tag->id, 'tag');
		$this->core->db->mysql_query('DELETE FROM tag_to_task WHERE tag_id = ' . $tag->id);
		$this->core->misc->setFlash('Тег удален', Sys_Misc::FLASH_OK);
		$this->core->misc->redirect('action=Task-showTaskList');
	}


}


