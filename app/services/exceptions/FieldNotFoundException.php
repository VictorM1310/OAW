<?php

namespace Service\Exception;

class FieldNotFoundException extends \Exception {
  function __construct($field) {
    parent::__construct("Field: $field does not exists!");
  }
}