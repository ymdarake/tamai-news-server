<?php

class BingNewsSearchApiClient {

	private $endPoint;
	private $apiKey;

	public function __construct($endPoint = BING_SEARCH_API_ENDPOINT, $apiKey = BING_SEARCH_API_KEY) {
		$this->endPoint = $endPoint;
		$this->apiKey = $apiKey;
	}

	public function search() {
		$term = '玉井詩織';

		if (strlen($this->apiKey) == 32) {
		    $json = $this->_search($term);
		    return $json;
		} else {
		    print("Invalid Bing Search API subscription key!\n");
		    print("Please paste yours into the source code.\n");
		}
	}

	private function _search($query) {
	    $options = ['http' => ['header' => "Ocp-Apim-Subscription-Key: {$this->apiKey}\r\n", 'Accept-Language' => "ja-JP", 'method' => 'GET']];
	    $context = stream_context_create($options);
	    $url = $this->endPoint . "?" . http_build_query(["q" => urlencode($query), "count" => "10", "originalImg" => "true"]);
	    $result = file_get_contents($url, false, $context);
	    return $result;

	    // Extract Bing HTTP headers
	    // $headers = array();
	    // foreach ($http_response_header as $k => $v) {
	    //     $h = explode(":", $v, 2);
	    //     if (isset($h[1]))
	    //         if (preg_match("/^BingAPIs-/", $h[0]) || preg_match("/^X-MSEdge-/", $h[0]))
	    //             $headers[trim($h[0])] = trim($h[1]);
	    // }
	    // return array($headers, $result);
	}

}