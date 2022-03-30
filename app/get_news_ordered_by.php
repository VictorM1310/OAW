<?php

use Service\FeedNewsService;

require_once '../bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

$rssId = $_GET['id'] ?? null;
$field = $_GET['field'] ?? null;
$sortOrder = $_GET['sort_order'] ?? null;

if (!$field || !$rssId) {
  http_response_code(400);
  echo json_encode(['error' => 'No Field or RSS ID provided!']);
  exit();
}

$field = filter_var($field, FILTER_UNSAFE_RAW);
$feedNewsService = $container->get(FeedNewsService::class);
echo json_encode($feedNewsService->getOrderedBy($rssId, $field, $sortOrder));