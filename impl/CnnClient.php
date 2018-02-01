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
				'description' => mb_substr(str_replace('<p>', '', str_replace('<![CDATA[<p>', '', $description)), 0, LINE_DESCRIPTION_MAX_LENGTH, 'UTF-8'),
				'link' => substr($item->link, 0, -strlen('?ref=rss')),
				'image' => $image
			];
		}

		return $result;
	}

}
