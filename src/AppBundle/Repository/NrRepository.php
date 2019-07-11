<?php

namespace AppBundle\Repository;

/**
 * NrRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NrRepository extends \Doctrine\ORM\EntityRepository
{

    public function getNr($client_id,$brand_id,$year,$month)
    {
        $query = $this->createQueryBuilder('a');
        $query->select('a.nr');
        $query->where('a.client=  :client_id');
        $query->setParameter('client_id', $client_id);

        $query->andWhere('a.brand=  :brand_id');
        $query->setParameter('brand_id', $brand_id);

        $query->andWhere('a.wMonth=  :wMonth');
        $query->setParameter('wMonth', $month);
        $query->setMaxResults(1);
        $query->andWhere('a.wYear=  :year');
        $query->setParameter('year', $year);
        $query = $query->getQuery();
        
        $nr= $query->getOneOrNullResult();
        if($nr)
        {
            return $nr['nr'];
        }
        return null;
        
        //get shops hq 
       
    }
    public function getNrRow($client_id,$brand_id,$year,$month)
    {
        $query = $this->createQueryBuilder('a');
      //  $query->select('a.nr');
        $query->where('a.client=  :client_id');
        $query->setParameter('client_id', $client_id);

        $query->andWhere('a.brand=  :brand_id');
        $query->setParameter('brand_id', $brand_id);

        $query->andWhere('a.wMonth=  :wMonth');
        $query->setParameter('wMonth', $month);
        $query->setMaxResults(1);
        $query->andWhere('a.wYear=  :year');
        $query->setParameter('year', $year);
        $query = $query->getQuery();
        return $query->getOneOrNullResult();
        
        //get shops hq 
       
    }

    public function getNrLy($client_id,$brand_id,$year,$month)
    {
        $year=$year-1;
        $query = $this->createQueryBuilder('a');
        $query->select('a.nr');
        $query->where('a.client=  :client_id');
        $query->setParameter('client_id', $client_id);

        $query->andWhere('a.brand=  :brand_id');
        $query->setParameter('brand_id', $brand_id);

        $query->andWhere('a.wMonth=  :wMonth');
        $query->setParameter('wMonth', $month);
        $query->setMaxResults(1);
        $query->andWhere('a.wYear=  :year');
        $query->setParameter('year', $year);
        $query = $query->getQuery();
        $nr= $query->getOneOrNullResult();
        return $nr;
        //get shops hq 
       
    }
}