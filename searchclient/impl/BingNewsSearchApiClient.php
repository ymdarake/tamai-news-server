<?php

namespace ymdarake\tamai\news\server\searchclient\impl;

use ymdarake\tamai\news\server\searchclient\SearchClient;


require_once(dirname(__DIR__) . "/SearchClient.php");

class BingNewsSearchApiClient implements SearchClient {

	private $endPoint;
	private $apiKey;
	private $word;

	public function __construct($endPoint = BING_SEARCH_API_ENDPOINT, $apiKey = BING_SEARCH_API_KEY) {
		$this->endPoint = $endPoint;
		$this->apiKey = $apiKey;
	}
	public function setWord($word) {
		$this->word = $word;
	}

	public function search() {
		if (strlen($this->apiKey) == 32) {
		    return $this->format($this->_search());
		} else {
		    print("Invalid Bing Search API subscription key!\n");
		    print("Please paste yours into the source code.\n");
		}
	}

	private function _search() {
	    $options = ['http' => ['header' => "Ocp-Apim-Subscription-Key: {$this->apiKey}\r\n", 'method' => 'GET']];
	    $context = stream_context_create($options);
	    // TODO: urlencodeして検索
	    $url = $this->endPoint . "?" . http_build_query(["q" => $this->word, 'freshness' => 'Week', 'count' => "20", 'mkt' => "ja-JP", "originalImg" => "true"]);
	    return file_get_contents($url, false, $context);
	}

	private function format($json) {
		$result = [];
		$assocArray = json_decode($json, true);
		foreach ($assocArray['value'] as $each) {
			$result[] = [
				'datePublished' => $each['datePublished'],
				'title' => $each['name'],
				'description' => $each['description'],
				'image' => isset($each['image']) ? $each['image']['thumbnail']['contentUrl'] : '',
				'link' => $each['url']
			];
		}
		return $result;
	}

}