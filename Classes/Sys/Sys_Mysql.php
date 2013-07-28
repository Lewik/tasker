<?php
class Sys_Mysql
{
	private $connection;
	/**
	 * @var Sys_Core
	 */
	private $core;

	public function init($core)
	{
		$this->core = $core;
		$this->connection =
			mysql_connect(
				$this->core->config->mysql_host,
				$this->core->config->mysql_user,
				$this->core->config->mysql_password
			);

		if (!$this->connection) {
			die("Could not connect : " .
				mysql_error());
		}
		mysql_set_charset('utf8') or die(mysql_error() . ' - ' . mysql_errno());
		mysql_select_db($this->core->config->mysql_base, $this->connection) or die(mysql_error() . ' - ' . mysql_errno());

	}

	public function get($objectOrArray, $sql, $keyField = false)
	{
		//$keyField - поле, значение которого будет использовано как ключ выдаваемого массива.
		$result = mysql_query($sql);
		if (!$result) {
			die(mysql_error() . ' - ' . mysql_errno());
		}
		$return = array();
		if (is_array($objectOrArray)) {
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				if ($keyField && isset($row[$keyField])) {
					$return[$row[$keyField]] = $row;
				} else {
					$return[] = $row;
				}
			}
		} else {
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$new = clone($objectOrArray);
				foreach ($row as $name => $value) {
					$new->$name = $row[$name];
				}

				if ($keyField && isset($new->$keyField)) {
					$return[$new->$keyField] = $new;
				} else {
					$return[] = $new;
				}

			}
		}


		return $return;
	}

	public function insert(Entity_Common $object, $table)
	{
		$rows = array();
		foreach ($object as $name => $value) {
			if ($name[0] == '_' || $name == 'id') {
				continue;
			}
			if (is_string($value)) {
				$value = "'" . $value . "'";
			}
			if ($value == '') {
				$value = "''";
			}
			$rows[] = $name . ' = ' . $value;

		}
		$sql = 'INSERT INTO ' . $table . ' SET ' . implode(',', $rows);
		mysql_query($sql);
		return mysql_insert_id();

	}

	public function update(Entity_Common $object, $table)
	{
		$rows = array();
		foreach ($object as $name => $value) {
			if ($name[0] == '_' || $name == 'id') {
				continue;
			}
			if (is_string($value)) {
				$value = "'" . $value . "'";
			}
			$rows[] = $name . ' = ' . $value;

		}
		$sql = 'UPDATE ' . $table . ' SET ' . implode(',', $rows) . '  WHERE  id = ' . $object->id . ' LIMIT 1 ';
		mysql_query($sql);
		return mysql_affected_rows();
	}

	public function delete($id, $table)
	{
		$sql = 'DELETE FROM ' . $table . ' WHERE  id = ' . $id . ' LIMIT 1 ';
		mysql_query($sql);
		return mysql_affected_rows();
	}

	public function mysql_query($query)
	{
		return mysql_query($query);
	}
}


