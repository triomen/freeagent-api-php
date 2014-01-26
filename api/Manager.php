<?php

/**
 * Interface describing what should implement every managers
 *
 */
interface Manager {

	/**
	 * Get all objects of this type
	 * Filter possible in arguments. Args values are defined as constant
	 */
	public function getAll();
}
