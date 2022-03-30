<?php

use Service\RSSFeedService;

require_once '../bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

$rssFeedService = $container->get(RSSFeedService::class);
echo json_encode($rssFeedService->getAll());