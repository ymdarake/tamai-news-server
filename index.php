<?php

$newsXml = new SimpleXMLElement(file_get_contents("http://feeds.cnn.co.jp/rss/cnn/cnn.rdf"));

$result = [];
foreach ($newsXml->item as $item) {
	$result[] = ['title' => $item->title, 'link' => $item->link, 'image' => $item->description];
	var_dump($item->description);
}

// echo json_encode($result);
