<?php

namespace AppBundle\Repository;

/**
 * settingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class settingRepository extends \Doctrine\ORM\EntityRepository
{
    public function getSetting()
    {
        $query = $this->createQueryBuilder('c');
        $query = $query->getQuery();
        $query->setMaxResults(1);
        return  $query->getOneOrNullResult();

        
    }

    public function getGridSetting()
    {
       // die("sdaas");
        $query = $this->createQueryBuilder('c');
       // $query->select('c.theme');
        $query = $query->getQuery();
        $query->setMaxResults(1);
        return  $query->getOneOrNullResult();

        
    }

   

    
}
