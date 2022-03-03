<?php

namespace Service;

use Core\XmlRSSFeedFetcher;
use Repository\RSSFeedRepository;

class RSSFeedService {
  private $rssFeedRepo;
  private $fetcher;

  function __construct(RSSFeedRepository $rssFeedRepo, XmlRSSFeedFetcher $fetcher) {
    $this->rssFeedRepo = $rssFeedRepo;
    $this->fetcher = $fetcher;
  }

  function getById($rssId) {
    return $this->rssFeedRepo->findBy(['id' => $rssId]);
  }

  function addOrGet($url) {
    if ($this->rssFeedRepo->existsByUrl($url)) {
      return $this->rssFeedRepo->get($url);
    }
    $rssFeed = $this->fetcher->fetchAndParseXmlRssFeed($url);
    $this->rssFeedRepo->save($rssFeed);
    return $this->rssFeedRepo->get($url);
  }
}