<?php
require_once 'Base.php';
/**
 * @see https://dev.freeagent.com/docs/bank_transaction_explanations
 *
 */
class BankExplanation extends Base {

	public $bank_transaction;
	public $bank_account;
	public $category;
	public $dated_on;
	public $description;
	public $gross_value;
	public $sales_tax_rate;

	//TODO : attachment

}
