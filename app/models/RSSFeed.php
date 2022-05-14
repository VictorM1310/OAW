<?php

namespace Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass = "Repository\RSSFeedRepository")
 * @ORM\Table(name = "rss_feeds")
 */
class RSSFeed implements JsonSerializable {
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
   * @ORM\Column(type = "string", unique = true)
   */
  private $url;

  /**
   * @ORM\OneToMany(targetEntity = "FeedNews", mappedBy = "rssFeed", cascade = {"all"}, orphanRemoval = true)
   * @ORM\OrderBy({"pubDate" = "DESC"})
   */
  private $news;

  function __construct(array $attr) {
    $this->title = $attr['title'];
    $this->description = $attr['description'];
    $this->url = $attr['url'];
    $news = new ArrayCollection();
  }

  function setNews(array $news) {
    foreach ($news as $new) {
      $this->news[] = $new;
      $new->setRssFeed($this);
    }
  }

  function clearNews() {
    $this->news->clear();
  }

  function jsonSerialize() {
    return [
      'id' => $this->id,
      'title' => $this->title,
      'description' => $this->description,
      'url' => $this->url,
      'news' => $this->news->map(function ($new) {
        return [
          'title' => $new->getTitle(),
          'description' => $new->getDescription(),
          'url' => $new->getUrl(),
          'pubDate' => $new->getPubDate(),
          'categories' => $new->getCategories()
        ];
      })->toArray()
    ];
  }

  function getId() {
    return $this->id;
  }

  function getTitle() {
    return $this->title;
  }

  function getDescription() {
    return $this->description;
  }

  function getUrl() {
    return $this->url;
  }

  function getNews() {
    return $this->news;
  }
}
