<?php

class CnnClient {

	public function __construct() {
	}

	public function search() {
		$newsXml = new SimpleXMLElement(file_get_contents("http://feeds.cnn.co.jp/rss/cnn/cnn.rdf"));
		
		$result = [];
		foreach ($newsXml->item as $item) {
			$description = (string)$item->description;
			preg_match("/<img src='(.*)'/", $description, $matches);
			$image = isset($matches[1]) ? $matches[1] : '';
			$result[] = [
				'title' => (string)$item->title,
				'description' => mb_substr(str_replace('<p>', '', str_replace('<![CDATA[<p>', '', $description)), 0, 60, 'UTF-8'),//長すぎるとタグが混じってパースできなくなるので60文字で切る
				'link' => substr($item->link, 0, -strlen('?ref=rss')),
				'image' => $image
			];
		}

		return $result;
	}

}
