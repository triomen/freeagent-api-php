<?php
require_once 'Manager.php';
require_once('FreeAgentApiBase.php');
require_once('model/BankExplanation.php');

/**
 * Manage multiple bank explanation object
 *
 */
class BankExplanations extends FreeAgentApiBase implements Manager {

	/**
	 * Get all bank account explanation
	 * @url https://dev.freeagent.com/docs/bank_transaction_explanations
	 * @param string $bankAccount bank account url or array. If null, get all accounts
	 * @param date $from optional YYYY-MM-DD
	 * @param date $to optional YYYY-MM-DD
	 * @return multitype:BankExplanation |boolean
	 */
	public function getAll($bankAccount = NULL, $from = NULL, $to = NULL) {
		//$params = (!empty($filter)) ? '?view='.$filter : NULL;
		$fromQuery = (!empty($from)) ? '&from_date=' . $from : NULL;
		$toQuery = (!empty($to)) ? '&to_date=' . $to : NULL;
		$toReturn = array();
		$urls = array();

		if ($bankAccount === NULL || is_array($bankAccount)) {
			$ba = new BankAccounts();
			$bankAccounts = $ba->getAll();
			foreach ($bankAccounts as $b) {
				$urls[] = $b->url;
			}
		} else {
			$urls[] = $bankAccount;
		}
		// foreach bank accounts
		foreach ($urls as $url) {
			$request['url'] = $GLOBALS['cfg']['api_url']
					. '/bank_transaction_explanations?bank_account='
					. $bankAccount . $fromQuery . $toQuery;

			$request['body'] = '';
			$request['method'] = 'GET';
			$request['type'] = 'application/json';
			$result = $this->invoke_api($request);

			if (NULL !== $result) {
				foreach ($result->bank_transaction_explanations as $bankExplanation) {
					$tmp = new BankExplanation();
					foreach ($bankExplanation as $name => $value) {
						$tmp->$name = $value;
					}
					$toReturn[] = $tmp;
				}
			} else {
				return false;
			}
		}
		return $toReturn;
	}
}

?>