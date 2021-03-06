<?php

namespace AppBundle\Repository;

/**
 * ProductPictureRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductPictureRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByPictureProduct($id)
    {
        return $this->findBy(array('picture_product' => $id),
            array('picture_order' => 'asc'));
    }
}
