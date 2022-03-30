<?php

namespace Service\Exception;

class CannotLoadFeedException extends \Exception {

  function __construct() {
    parent::__construct('Cannot load feed! Check the provided URL.');
  }
}