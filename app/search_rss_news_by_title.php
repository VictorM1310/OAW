<?php

use Service\FeedNewsService;

require_once '../bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

$rssId = $_GET['id'] ?? null;
$title = $_GET['title'] ?? null;

if (!$title || !$rssId) {
  http_response_code(400);
  echo json_encode(['error' => 'No Title or RSS ID provided!']);
  exit();
}

$title = filter_var($title, FILTER_UNSAFE_RAW);
$feedNewsService = $container->get(FeedNewsService::class);
$rssFeedsMatching = $feedNewsService->searchByTitle($rssId, $title);

echo json_encode($rssFeedsMatching);