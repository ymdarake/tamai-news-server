<?php

require_once(__DIR__ . '/vendor/autoload.php');

$newsXml = new SimpleXMLElement(file_get_contents("http://feeds.cnn.co.jp/rss/cnn/cnn.rdf"));

$result = [];
foreach ($newsXml->item as $item) {
	$description = (string)$item->description;
	preg_match("/<img src='(.*)'/", $description, $matches);
	$image = isset($matches[1]) ? $matches[1] : '';
	$result[] = [
		'title' => $item->title[0],
		'description' => mb_substr($item->description, 0, 100, 'UTF-8'),
		'link' => substr($item->link, 0, -strlen('?ref=rss')),
		'image' => $image
	];
}

echo json_encode($result);
