<?php

namespace AppBundle\Repository;

/**
 * BrandRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OldBrandRepository extends \Doctrine\ORM\EntityRepository
{

 public function getSubBrand($col,$id)
    {
      //  echo $col;die();
        
        $query = $this->createQueryBuilder('b');
                 $query->select('b.'.$col);
                 $query->Where('b.idbrand = :IDBrand');
                 $query->setParameter('IDBrand',$id);
                 $query = $query->getQuery();
                // dump($query->getSql());die();
        return $query->getOneOrNullResult();
    }




}
