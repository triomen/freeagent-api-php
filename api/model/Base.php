<?php
require_once(__DIR__ . '/../FreeAgentApiBase.php');
/**
 * Base class for all objects
 * 
 */
abstract class Base extends FreeAgentApiBase {

	/**
	 * URL of the object in FreeAgent
	 * @var string
	 */
	public $url;

	/**
	 * If an URL is given, it fills the current object with what the webservice returns
	 * @param string $url
	 * @return multitype:|boolean
	 * Example : https://api.freeagent.com/v2/invoices/7668521
	 */
	public function __construct($url = NULL) {
		if ($url !== NULL) {
			parent::__construct();
			$request['url'] = $url;
			$request['body'] = '';
			$request['method'] = 'GET';
			$request['type'] = 'application/json';

			$result = $this->invoke_api($request);
			if (NULL !== $result) {
				$first = key(get_object_vars($result));

				foreach ($this as $property => $value) {
					$this->$property = isset($result->$first->$property) ? $result
									->$first->$property : NULL;
				}

			} else {
				throw new Exception($url . ' returns nothing');
			}
		}
	}
}
