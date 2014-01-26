<?php
require_once 'Base.php';
/**
 * @see https://dev.freeagent.com/docs/categories
 *
 */
class Category extends Base {

	public $type;
	public $description;
	public $nominal_code;
	public $allowable_for_tax;
	public $tax_reporting_name;
	public $auto_sales_tax_rate;

}
