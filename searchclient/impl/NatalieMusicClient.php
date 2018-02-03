<?php

namespace ymdarake\tamai\news\server\searchclient\impl;

use ymdarake\tamai\news\server\searchclient\SearchClient;
use SimpleXMLElement;
use DOMDocument;

require_once(dirname(__DIR__) . "/SearchClient.php");

class NatalieMusicClient implements SearchClient {

	public function __construct() {
	}

	public function search() {

		$xmlString = $this->loadHtml()->saveXML();
		$xmlObject = new SimpleXMLElement($xmlString);
		$articles = $xmlObject->body->div->div->article->div->ul[0];
		
		$result = [];
		foreach ($articles as $article) {
			$detail = $article->a->dl;
			preg_match("/background-image: url\((.*)\);/", (string)$article->a->span["style"], $matches);
			$result[] = [
				'datePublished' => (string)$detail->dd[1]->time,
				'title' => (string)$detail->dt,
				'description' => (string)$detail->dd,
				'link' => (string)$article->a["href"],
				'image' => isset($matches[1]) ? $matches[1] : ""
			];
		}

		return $result;
	}

	private function loadHtml() {
		$domDocument = new DOMDocument();
		@$domDocument->loadHTML(mb_convert_encoding(file_get_contents('https://natalie.mu/music/news/list/artist_id/7630'), 'HTML-ENTITIES', 'ASCII, JIS, UTF-8, EUC-JP, SJIS'));
		return $domDocument;
	}

}
