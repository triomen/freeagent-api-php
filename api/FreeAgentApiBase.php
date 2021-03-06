<?php
require_once('config.inc.php');
/**
 * This is the FreeAgent API Base Class. Do not instanciate this class directly.
 * Inspired : https://github.com/nickheppleston
 */ 
abstract class FreeAgentApiBase {

	private $debug;
	static protected $oauth_access_token;
	protected $api_url;
	protected $ch;
	public $response;
	public $error;

	public function __construct($debug = false) {
		$this->debug = $debug;
		self::$oauth_access_token = $GLOBALS['cfg']['api_key'];
		$this->ch = curl_init();

		// Instanciate API response array
		$this->response = array('http_response_headers' => '',
				'http_response_body' => '', 'http_response_status_code' => '');

		// Instanciate error array
		$this->error = array('error_source' => '', 'error_message' => '');

	}

	/**
	 * Print sth in debug mode
	 * @param unknown $debug_stmt
	 */
	private function print_debug($debug_stmt) {
		if ($this->debug)
			print $debug_stmt;
	}

	/**
	 * Parse HTTP headers
	 * @param string $headers headers to parse
	 * @return array
	 */
	private function http_parse_headers($headers = false) {
		if ($headers === false) {
			return false;
		}

		$headers = str_replace("\r", "", $headers);
		$headers = explode("\n", $headers);

		foreach ($headers as $value) {
			$header = explode(": ", $value);

			if (($header[0]) && (!isset($header[1]))) {
				$headerdata['status'] = $header[0];
			}
			if (($header[0]) && (isset($header[1]))) {
				$headerdata[$header[0]] = $header[1];
			}
		}

		return $headerdata;
	}

	/**
	 * Make the request to the api
	 * @param array $request request to send
	 * @throws Exception
	 * @return boolean|NULL|mixed
	 */
	protected function invoke_api($request) {
		if (empty(self::$oauth_access_token))
			throw new Exception('Please give access token');
		// Setup CUrl
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->ch, CURLOPT_HEADER, 1);
		curl_setopt($this->ch, CURLOPT_VERBOSE, 1);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->ch, CURLOPT_URL, $request['url']);
		curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $request['method']);
		curl_setopt($this->ch, CURLOPT_USERAGENT, $GLOBALS['cfg']['user_agent']);

		// Configure request body for normal API request or OAuth request
		if ((isset($request['oauth'])) && ($request['oauth'] == true)) {
			// OAuth API request
			curl_setopt($this->ch, CURLOPT_HTTPHEADER,
					array('Accept: ' . $request['type'],
							'Content-type: application/x-www-form-urlencoded',
							'Content-length:' . strlen($request['body']),));
		} else {
			// 'Normal' API request
			curl_setopt($this->ch, CURLOPT_HTTPHEADER,
					array(
							"Authorization: Bearer "
									. self::$oauth_access_token,
							"Accept: " . $request['type'],
							"Content-type: " . $request['type'],
					//"Content-length:". strlen($request['body']),
					));
		}

		$this->print_debug('Request Data *Body*: ' . $request['body']);

		if (isset($request['body'])) {
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, $request['body']);
		}

		// Invoke API
		$response = curl_exec($this->ch);

		// Parse CUrl for errors invoking the API
		if (($error = curl_error($this->ch)) != '') {
			$this->error['error_source'] = "CUrl";
			$this->error['error_message'] = $error;
			return false;
		}

		// Parse API resonse
		$response_header_size = curl_getinfo($this->ch, CURLINFO_HEADER_SIZE);
		$this->response['http_response_headers'] = $this
				->http_parse_headers(
						substr($response, 0, $response_header_size));
		$this->response['http_response_body'] = substr($response,
				$response_header_size);
		$this->response['http_response_status_code'] = curl_getinfo($this->ch,
				CURLINFO_HTTP_CODE);

		// Parse response body for errors raise by the API
		// Error message will be JSON, e.g. '{"errors":{"error":{"message":"Access token not recognised"}}}''
		$error_arr = json_decode($this->response['http_response_body'], true);
		if (isset($error_arr['errors'])) {
			$this->error['error_source'] = "FreeAgentAPI";
			$this->error['error_message'] = $error_arr['errors']['error']['message'];
			return null;
		}

		// DEBUGGING
		$this->print_debug('<p>**DEBUGGING**</p>');
		$this->print_debug("<p><strong>Headers Array:</strong></p>");
		// var_dump($this->response['http_response_headers']);
		$this->print_debug("<p><strong>Body:</strong></p>");
		$this->print_debug($this->response['http_response_body']);
		$this
				->print_debug(
						'<p><strong>HTTP Status Response Code:</strong> '
								. $this->response['http_response_status_code']
								. '</p>');
		// print "<br />Last URL: ". $result['last_url'];
		$this->print_debug('<p>**DEBUGGING**</p>');
		// DEBUGGING

		return json_decode($this->response['http_response_body']);
	}

}

?>