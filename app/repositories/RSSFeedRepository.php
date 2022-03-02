<?php

namespace Repository;

use Doctrine\ORM\EntityRepository;

class RSSFeedRepository extends EntityRepository {

  function get($url) {
    return $this->findOneBy(['url' => $url]);
  }

  function save($rssFeed) {
    $entityManager = $this->getEntityManager();
    $entityManager->persist($rssFeed);
    $entityManager->flush();
  }

  function existsByUrl($url) {
    return $this->countByUrl($url) > 0;
  }
}