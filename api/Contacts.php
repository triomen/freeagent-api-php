<?php
require_once 'Manager.php';
require_once('FreeAgentApiBase.php');
require_once('model/Contact.php');

/**
 * Manage multiple contact objects
 *
 */
class Contacts extends FreeAgentApiBase implements Manager {

	const ACTIVE = 'active';
	const CLIENTS = 'clients';
	const SUPPLIERS = 'suppliers';
	const ACTIVE_PROJECTS = 'active_projects';
	const OPEN_CLIENTS = 'open_clients';
	const OPEN_SUPPLIERS = 'open_suppliers';
	const HIDDEN = 'hidden';

	/**
	 * Get all contacts
	 * @url https://api.freeagent.com/v2/contacts
	 * @param string $filter use const class to filter some invoices
	 * @return multitype:Contacts |boolean
	 */
	public function getAll($filter = NULL) {
		$params = (!empty($filter)) ? '?view=' . $filter : NULL;

		$request['url'] = $GLOBALS['cfg']['api_url'] . '/contacts' . $params;
		$request['body'] = '';
		$request['method'] = 'GET';
		$request['type'] = 'application/json';
		$result = $this->invoke_api($request);

		if (null !== $result) {
			$toReturn = array();
			foreach ($result->contacts as $contact) {
				$tmp = new Contact();
				foreach ($contact as $name => $value) {
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