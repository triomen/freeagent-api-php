<?php
require_once 'Manager.php';
require_once('FreeAgentApiBase.php');
require_once('model/Project.php');

/**
 * Manage multiple category objects
 *
 */
class Projects extends FreeAgentApiBase implements Manager {

	const ACTIVE = 'active';
	const COMPLETED = 'completed';
	const CANCELLED = 'cancelled';
	const HIDDEN = 'hidden';
	/**
	 * Get all projects
	 * @url https://api.freeagent.com/v2/projects
	 * @param string $filter use const class to filter some invoices
	 * @return multitype:Project |boolean
	 */
	public function getAll($filter = NULL) {
		$params = (!empty($filter)) ? '?view=' . $filter : NULL;

		$request['url'] = $GLOBALS['cfg']['api_url'] . '/projects' . $params;
		$request['body'] = '';
		$request['method'] = 'GET';
		$request['type'] = 'application/json';
		$result = $this->invoke_api($request);

		if (null !== $result) {
			$toReturn = array();
			foreach ($result->projects as $project) {
				$tmp = new Project();
				foreach ($project as $name => $value) {
					$tmp->$name = $value;
				}
				$toReturn[] = $tmp;
			}
			return $toReturn;
		} else {
			return false;
		}

	}

}

?>