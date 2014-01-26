<?php
require_once('Base.php');

/**
 * 
 * @see https://dev.freeagent.com/docs/contacts
 */
class Contact extends Base {

	public $organisation_name;
	public $address1;
	public $address2;
	public $address3;
	public $town;
	public $charge_sales_tax;
	public $first_name;
	public $last_name;
	public $contact_name_on_invoices;
	public $country;
	public $locale;
	public $account_balance;
	public $uses_contact_invoice_sequence;
	public $created_at;
	public $updated_at;
}
