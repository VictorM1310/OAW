<?php


namespace Service\Exception;

class RSSFeedNotFoundException extends \Exception {

  function __construct($rssId) {
    parent::__construct("RSS Feed with ID: $rssId does not exists!");
  }
}