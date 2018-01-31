<?php

$newsXml = new SimpleXMLElement(file_get_contents("http://feeds.cnn.co.jp/rss/cnn/cnn.rdf"));

$result = [];
foreach ($newsXml->item as $item) {
	$result[] = ['title' => $item->title, 'link' => $item->link, 'image' => $item->description];
	$str = (string)$item->description;
	preg_match("/<img src='(.*)'/", $str, $matches);
	var_dump($matches);
}
