<?php

namespace Core;

use DateTime;
use Feed;
use FeedException;
use Model\FeedNews;
use Model\RSSFeed;
use Service\Exception\CannotLoadFeedException;

class XmlRSSFeedFetcher {
  function fetchAndParseXmlRssFeed($url) {
    try {
      return $this->tryToFetchAndParseXmlRssFeed($url);
    } catch (FeedException $exception) {
      throw new CannotLoadFeedException();
    }
  }

  private function tryToFetchAndParseXmlRssFeed($url) {
    $xmlRssFeed = Feed::load($url);
    return $this->parseXmlRssFeed($url, $xmlRssFeed);
  }

  private function parseXmlRssFeed($urlRss, $xmlRssFeed) {
    $rssFeed = new RSSFeed(
      [
        'url' => $urlRss,
        'title' => (string) $xmlRssFeed->title,
        'description' => (string) $xmlRssFeed->description,
      ]
    );
    $feedNews = $this->extractNews($xmlRssFeed);
    $rssFeed->setNews($feedNews);
    return $rssFeed;
  }

  private function extractNews($xmlRssFeed) {
    $feedNews = [];
    foreach ($xmlRssFeed->item as $news) {
      $feedNews[] = new FeedNews(
        [
          'title' => (string) $news->title,
          'description' => (string) $news->description,
          'url' => (string) $news->link,
          'pubDate' => new DateTime((string) $news->pubDate),
          'categories' => (array) $news->category
        ]
      );
    }
    return $feedNews;
  }
}