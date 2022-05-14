<?php

namespace Service;

use Core\XmlRSSFeedFetcher;
use Dto\RSSFeedDto;
use Repository\RSSFeedRepository;

class RSSFeedService {
  private $rssFeedRepo;
  private $fetcher;

  function __construct(RSSFeedRepository $rssFeedRepo, XmlRSSFeedFetcher $fetcher) {
    $this->rssFeedRepo = $rssFeedRepo;
    $this->fetcher = $fetcher;
  }

  function getAll() {
    $rssFeeds = $this->rssFeedRepo->findAll();
    return array_map(function ($rssFeed) {
      return new RSSFeedDto($rssFeed);
    }, $rssFeeds);
  }

  function getById($rssId) {
    return $this->rssFeedRepo->findOneBy(['id' => $rssId]);
  }

  function addOrGet($url) {
    if ($this->rssFeedRepo->existsByUrl($url)) {
      return $this->rssFeedRepo->get($url);
    }
    $rssFeed = $this->fetcher->fetchAndParseXmlRssFeed($url);
    $this->rssFeedRepo->save($rssFeed);
    return $this->rssFeedRepo->get($url);
  }

  function update($selectedRssFeed) {
    $rssFeeds = $this->getAll();
    foreach ($rssFeeds as $rssFeed) {
      $rssFeed->clearNews();
      $updatedRssFeed = $this->fetcher->fetchAndParseXmlRssFeed($rssFeed->getUrl());
      $rssFeed->setNews($updatedRssFeed->getNews());
      $this->rssFeedRepo->save($rssFeed);
    }
    return $this->getById($selectedRssFeed);
  }
}
