<?php

namespace Service;

use Feed;
use Model\FeedNews;
use Model\RSSFeed;
use Repository\RSSFeedRepository;

class RSSFeedService {
  private $rssFeedRepo;

  function __construct(RSSFeedRepository $rssFeedRepo) {
    $this->rssFeedRepo = $rssFeedRepo;
  }

  function addOrGetRssFeed($url) {
    if ($this->rssFeedRepo->existsByUrl($url)) {
      return $this->rssFeedRepo->get($url);
    }
    $xmlRssFeed = $this->fetchXmlRssFeed($url);
    $rssFeed = $this->parseXmlRssFeed($url, $xmlRssFeed);
    $this->rssFeedRepo->save($rssFeed);
    return $this->rssFeedRepo->get($url);
  }

  function fetchXmlRssFeed($url) {
    return Feed::loadRss($url);
  }

  function parseXmlRssFeed($url, $xmlRssFeed) {
    $rssFeed = new RSSFeed(
      [
        'url' => $url,
        'title' => (string) $xmlRssFeed->title,
        'description' => (string) $xmlRssFeed->description,
      ]
    );
    $feedNews = $this->extractNews($xmlRssFeed);
    $rssFeed->setNews($feedNews);
    return $rssFeed;
  }

  function extractNews($xmlRssFeed) {
    $feedNews = [];
    foreach ($xmlRssFeed->item as $news) {
      $feedNews[] = new FeedNews(
        [
          'title' => (string) $news->title,
          'description' => (string) $news->description,
          'url' => (string) $news->link,
          'pubDate' => (string) $news->pubDate,
          'categories' => (array) $news->category
        ]
      );
    }
    return $feedNews;
  }
}