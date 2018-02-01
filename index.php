<?php

require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . "/config/env.php");
require_once(__DIR__ . "/impl/BingNewsSearchApiClient.php");
require_once(__DIR__ . "/impl/CnnClient.php");


$searchWhiteList = ["玉井詩織", "百田夏菜子", "ももクロ", "ももいろクローバーZ", "佐々木彩夏", "高城れに", "ももいろクローバー"];

if (isset($_GET['word']) && in_array($_GET['word'], $searchWhiteList)) {
	$client = new BingNewsSearchApiClient();
	echo json_encode($client->search($_GET['word']));
	exit;
}

echo json_encode((new CnnClient())->search());
exit;
