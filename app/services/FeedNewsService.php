<?php

namespace Service;

use Repository\FeedNewsRepository;

class FeedNewsService {
  private $feedNewsRepository;

  function __construct(FeedNewsRepository $feedNewsRepository) {
    $this->feedNewsRepository = $feedNewsRepository;
  }

  function searchByTitle($rssId, $title) {
    return $this->feedNewsRepository->searchByTitle($rssId, $title);
  }
}