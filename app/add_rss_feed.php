<?php

use Service\RSSFeedService;

require_once '../bootstrap.php';

$url = $_GET['url'] ?? null;

if (!$url) {
  echo json_encode(['error' => 'No RSS Feed provided']);
  exit();
}

$rssFeedService = $container->get(RSSFeedService::class);
$rssFeed = $rssFeedService->addOrGetRssFeed($url);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($rssFeed);