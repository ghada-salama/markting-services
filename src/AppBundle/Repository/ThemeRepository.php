<?php

namespace AppBundle\Repository;

/**
 * ThemeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ThemeRepository extends \Doctrine\ORM\EntityRepository
{
    public function getClientThems($client_id)
    {
        //die("sdsds");
        $query = $this->createQueryBuilder('c');
                $query->where('c.client = :client_id');
                $query->setParameter('client_id',$client_id);
                $query->andWhere('c.flag !=  1');
                $query = $query->getQuery();
        return $query->getResult();
       
        
    }
    public function getAllThems()
    {
        //die("sdsds");
        $query = $this->createQueryBuilder('c');
                $query->where('c.flag !=  1');
                $query = $query->getQuery();
        return $query->getResult();
       
        
    }


}
