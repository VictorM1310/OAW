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

  /**
   * Esta función esta pensada para rellenar el combobox de los RSS Feeds.
   * Por el momento retorna todas las Feeds con TODAS las noticias, 
   * propongo dejarlo así con el fin de poner números más interesantes 
   * en el reporte de VH.
   */
  function getAll() {
    return $this->rssFeedRepo->findAll();
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