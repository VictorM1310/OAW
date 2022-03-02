<?php

namespace Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "news")
 */
class FeedNews {
  /**
   * @ORM\Id
   * @ORM\Column(type = "integer")
   * @ORM\GeneratedValue
   */
  private $id;

  /**
   * @ORM\Column(type = "string")
   */
  private $title;

  /**
   * @ORM\Column(type = "string")
   */
  private $description;

  /**
   * @ORM\Column(type = "string")
   */
  private $url;

  private $pubDate;

  private $categories;

  /**
   * @ORM\ManyToOne(targetEntity = "RSSFeed", inversedBy = "news")
   */
  private $rssFeed;

  function __construct($attr) {
    $this->title = $attr['title'];
    $this->description = $attr['description'];
    $this->url = $attr['url'];
    $this->pubDate = $attr['pubDate'];
    $this->categories = $attr['categories'];
  }

  function setRssFeed($rssFeed) {
    $this->rssFeed = $rssFeed;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getDescription() {
    return $this->description;
  }

  public function getUrl() {
    return $this->url;
  }
}