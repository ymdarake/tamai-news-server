<?php

$newsXml = new SimpleXMLElement(file_get_contents("http://feeds.cnn.co.jp/rss/cnn/cnn.rdf"));

var_dump($newsXml);

foreach ($newsXml->item as $item) {
	echo $item->title;
	echo $item->link;
}
