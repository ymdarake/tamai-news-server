<?php

$newsXml = new SimpleXMLElement(file_get_contents("http://feeds.cnn.co.jp/rss/cnn/cnn.rdf"));

$result = [];
foreach ($newsXml->item as $item) {
	$str = (string)$item->description;
	preg_match("/<img src='(.*)'/", $str, $matches);
	$image = isset($matches[1]) ? $matches[1] : '';
	$result[] = [
		'title' => $item->title,
		'link' => substr($item->link, 0, -strlen('?ref=rss')),
		'image' => $image
	];
}

echo json_encode($result);
