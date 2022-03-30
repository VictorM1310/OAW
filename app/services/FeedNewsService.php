<?php

namespace Service;

use Model\FeedNews;
use Repository\FeedNewsRepository;
use Service\Exception\FieldNotFoundException;

class FeedNewsService {
  private $feedNewsRepo;

  function __construct(FeedNewsRepository $feedNewsRepo) {
    $this->feedNewsRepo = $feedNewsRepo;
  }

  function searchByTitle($rssId, $title) {
    return $this->feedNewsRepo->searchByTitle($rssId, $title);
  }

  function getOrderedBy($rssId, $field, $sortOrder) {
    if (!property_exists(FeedNews::class, $field)) {
      throw new FieldNotFoundException($field);
    }
    if (!in_array($sortOrder, ['asc', 'desc'])) {
      $sortOrder = null;
    }
    return $this->feedNewsRepo->getOrderedBy($rssId, $field, $sortOrder);
  }
}