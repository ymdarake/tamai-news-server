<?php

require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . "/config/env.php");
require_once(__DIR__ . "/impl/BingNewsSearchApiClient.php");
require_once(__DIR__ . "/impl/CnnClient.php");


$_GET['word'] = "玉井詩織";

if (isset($_GET['word'])) {
	$client = new BingNewsSearchApiClient();
	echo json_encode($client->search($_GET['word']));
	exit;
}

echo json_encode((new CnnClient())->search());
exit;
