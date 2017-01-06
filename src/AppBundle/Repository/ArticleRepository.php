<?php

namespace AppBundle\Repository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array('article_active' => 1));
    }
    
    public function find($id)
    {
        return $this->findOneBy(array('article_id' => $id, 'article_active' => 1));
    }
}
