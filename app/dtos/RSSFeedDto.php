<?php

namespace Dto;

use JsonSerializable;

class RSSFeedDto implements JsonSerializable {
  private $id;
  private $title;
  private $description;
  private $url;

  function __construct($rssFeed) {
    $this->id = $rssFeed->getId();
    $this->title = $rssFeed->getTitle();
    $this->description = $rssFeed->getDescription();
    $this->url = $rssFeed->getUrl();
  }

  function jsonSerialize() {
    return [
      'id' => $this->id,
      'title' => $this->title,
      'description' => $this->description,
      'url' => $this->url
    ];
  }
}
