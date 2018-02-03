<?php

require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . "/config/env.php");
require_once(__DIR__ . "/searchclient/impl/BingNewsSearchApiClient.php");
require_once(__DIR__ . "/searchclient/impl/CnnClient.php");
require_once(__DIR__ . "/searchclient/impl/NatalieMusicClient.php");

use tamai\news\server\searchclient\impl\BingNewsSearchApiClient;
use tamai\news\server\searchclient\impl\CnnClient;
use tamai\news\server\searchclient\impl\NatalieMusicClient;

$_GET["word"] = "natalie";

$searchClient = getSearchClient();
$searchResult = $searchClient->search();
echo json_encode($searchResult);
exit;

function getSearchClient() {
	if (!isKeywordSearch()) {
		return new CnnClient();
	}

	if (isNatalieSearch()) {
		return new NatalieMusicClient();
	}

	$client = new BingNewsSearchApiClient();
	$client->setWord(getWord());
	return $client;
}

function isKeywordSearch() {
	$searchWhiteList = ["玉井詩織", "百田夏菜子", "ももクロ", "ももいろクローバーZ", "佐々木彩夏", "高城れに", "ももいろクローバー", "natalie"];
	return !empty(getWord()) && in_array(getWord(), $searchWhiteList);
}

function isNatalieSearch() {
	return getWord() === 'natalie';
}

function getWord() {
	return isset($_GET["word"]) ? $_GET["word"] : "";
}
