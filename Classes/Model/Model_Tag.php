<?php
class Model_Tag extends Model_Common
{
	/**
	 * @var Sys_Core
	 */
	protected $core;


	public function getUserTags($userId)
	{
		$sql = 'SELECT id, name, user_id FROM tag WHERE user_id = ' . $userId . ' ORDER BY name';
		return $user = $this->core->db->get(new Entity_Tag(), $sql, 'id');
	}

	public function unlinkTagsFromTask($id)
	{
		$sql = 'DELETE FROM tag_to_task WHERE task_id IN(SELECT id FROM task WHERE id = ' . $id . ' AND user_id = ' . $this->core->user->id . ')';
		$this->core->db->mysql_query($sql);
	}

	public function linkTagsToTask($taskId, $tags)
	{
		foreach ($tags as $tag) {
			$sql = 'INSERT INTO tag_to_task SET task_id = ' . $taskId . ', tag_id = ' . $tag;
			$this->core->db->mysql_query($sql);
		}
	}

	public function getTagsForTask($id)
	{
		$sql = 'SELECT tag_id FROM tag_to_task WHERE task_id = ' . $id;
		$result = $this->core->db->get(array(), $sql);
		$result2 = array();
		foreach ($result as $subArray) {
			$result2[] = $subArray['tag_id'];
		}
		return $result2;
	}

	public function setTaskListTag($id)
	{
		if ($id == '__all') {
			$_SESSION['taskListTag'] = '';
		} else {
			$_SESSION['taskListTag'] = $id;
		}

	}

	public function getTaskListTag()
	{
		if (isset($_SESSION['taskListTag']) && $_SESSION['taskListTag'] != '') {
			return $_SESSION['taskListTag'];
		} else {
			return false;
		}

	}
}
