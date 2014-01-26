<?php
require_once 'Base.php';
require_once 'Contact.php';
require_once 'Project.php';

/**
 * Fields description, see FreeAgent API
 * @see https://dev.freeagent.com/docs/invoices
 */
class Invoice extends Base {

	public $contact;
	public $dated_on;
	public $due_on;
	public $reference;
	public $currency;
	public $exchange_rate;
	public $net_value;
	public $sales_tax_value;
	public $status;
	public $comments;
	public $omit_header;
	public $payment_terms_in_days;
	public $ec_status;

	// Not an all invoices
	public $project;
	public $total_value;
	public $paid_value;
	public $due_value;
	public $po_reference;
	public $paid_on;

	/**
	 * If contact field is filled, return a contact object.
	 * Otherwise, return the value 
	 * @return Contact|mixed
	 */
	public function getContact() {
		if (!empty($this->contact) && is_string($this->contact)) {
			$this->contact = new Contact($this->contact);
			return $this->contact;
		} else if (!is_string($this->contact)) {
			return $this->contact;
		}
	}

	/**
	 * If a project does exist, return the project object
	 * Otherwise, return the value of project
	 * @return Project|mixed
	 */
	public function getProject() {
		//TODO : get project
	}

}
