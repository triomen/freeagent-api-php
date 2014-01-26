<?php
require_once 'Manager.php';
require_once('FreeAgentApiBase.php');
require_once('model/Category.php');

/**
 * Manage multiple category objects
 *
 */
class Categories extends FreeAgentApiBase implements Manager {

	/**
	 * Get all categories
	 * @url https://api.freeagent.com/v2/categories
	 * @return multitype:Category |boolean
	 */
	public function getAll() {
		$request['url'] = $GLOBALS['cfg']['api_url'] . '/categories';
		$request['body'] = '';
		$request['method'] = 'GET';
		$request['type'] = 'application/json';
		$result = $this->invoke_api($request);

		if (null !== $result) {
			$toReturn = array();
			foreach ($result as $type => $category) {
				foreach ($category as $name => $catType) {
					$tmp = new Category();
					$tmp->type = $type;
					foreach ($catType as $k => $v) {
						$tmp->$k = $v;
					}
					$toReturn[] = $tmp;
				}
			}
			return $toReturn;
		} else {
			return false;
		}

	}

}

?>