<?php

namespace Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Parameter;

class FeedNewsRepository extends EntityRepository {

  function searchByTitle($rssId, $title) {
    $result  = $this->createQueryBuilder('n')
      ->leftJoin('n.rssFeed', 'rf')
      ->andWhere('rf.id = :id')
      ->andWhere('n.title LIKE :title')
      ->setParameters(new ArrayCollection([
        new Parameter('id', $rssId),
        new Parameter('title', '%' . $title . '%')
      ]))
      ->getQuery()
      ->getResult();

    return $result;
  }
}