<?php

require_once 'Base.php';
require_once 'Contact.php';

/**
 * @see https://dev.freeagent.com/docs/projects
 *
 */
class Project extends Base {

	public $name;
	public $contact;
	public $budget;
	public $is_ir35;
	public $status;
	public $budget_units;
	public $normal_billing_rate;
	public $hours_per_day;
	public $uses_project_invoice_sequence;
	public $currency;
	public $billing_period;
	public $created_at;
	public $updated_at;

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
}
