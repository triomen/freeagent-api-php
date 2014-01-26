<?php
require_once 'Manager.php';
require_once('FreeAgentApiBase.php');
require_once('model/Invoice.php');

/**
 * To deal with invoice objects *
 */
class Invoices extends FreeAgentApiBase implements Manager {

	const RECENT_OPEN_OR_OVERDUE = 'recent_open_or_overdue';
	const OPEN_OR_OVERDUE = 'open_or_overdue';
	const DRAFT = 'draft';

	/**
	 * Get all invoices
	 * @url https://api.freeagent.com/v2/invoices
	 * @param string $filter use const class to filter some invoices
	 * @return multitype:Invoice |boolean
	 */
	public function getAll($filter = NULL) {
		$params = (!empty($filter)) ? '?view=' . $filter : NULL;

		$request['url'] = $GLOBALS['cfg']['api_url'] . '/invoices' . $params;
		$request['body'] = '';
		$request['method'] = 'GET';
		$request['type'] = 'application/json';
		$result = $this->invoke_api($request);

		if (null !== $result) {
			$toReturn = array();
			foreach ($result->invoices as $invoice) {
				$tmp = new Invoice();
				foreach ($invoice as $name => $value) {
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

