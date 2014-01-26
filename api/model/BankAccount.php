<?php
require_once 'Base.php';
/**
 * @see https://dev.freeagent.com/docs/bank_accounts
 *
 */
class BankAccount extends Base {

	public $opening_balance;
	public $type;
	public $name;
	public $is_personal;
	public $current_balance;
	public $updated_at;
	public $created_at;
}
