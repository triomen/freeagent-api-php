<?php
require_once 'Manager.php';
require_once('FreeAgentApiBase.php');
require_once('model/BankAccount.php');
/**
 * 
 * Manage multiple Bank accounts objects
 *
 */
class BankAccounts extends FreeAgentApiBase implements Manager {

	/**
	 * Get all bank account explanation
	 * @url https://dev.freeagent.com/docs/bank_transaction_explanations
	 * @return multitype:BankExplanation |boolean : false if there is an error
	 */
	public function getAll() {
		$request['url'] = $GLOBALS['cfg']['api_url'] . '/bank_accounts';
		$request['body'] = '';
		$request['method'] = 'GET';
		$request['type'] = 'application/json';
		$result = $this->invoke_api($request);

		if (null !== $result) {
			$toReturn = array();
			foreach ($result->bank_accounts as $bankAccounts) {
				$tmp = new BankAccount();
				foreach ($bankAccounts as $name => $value) {
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