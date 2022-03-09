<?php

use Service\RSSFeedService;

require_once '../bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

$selectedRssId = $_GET['selected_rss'] ?? null;

$rssFeedService = $container->get(RSSFeedService::class);
$selectedRssFeed = $rssFeedService->update($selectedRssId);
echo json_encode($selectedRssFeed);