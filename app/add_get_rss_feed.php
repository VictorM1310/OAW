<?php

use Service\Exception\CannotLoadFeedException;
use Service\RSSFeedService;

require_once '../bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

$url = $_GET['url'] ?? null;

if (!$url) {
  http_response_code(400);
  echo json_encode(['error' => 'No RSS Feed URL provided!']);
  exit();
}

$url = filter_var($url, FILTER_SANITIZE_URL);
$rssFeedService = $container->get(RSSFeedService::class);

try {
  $rssFeed = $rssFeedService->addOrGet($url);
  echo json_encode($rssFeed);
} catch (CannotLoadFeedException $e) {
  http_response_code(400);
  echo json_encode(['error' => $e->getMessage()]);
}