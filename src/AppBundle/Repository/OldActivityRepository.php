<?php

namespace AppBundle\Repository;

/**
 * RealDataRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OldActivityRepository extends \Doctrine\ORM\EntityRepository
{

    public function getFirst()
    { 
        return $this->createQueryBuilder('c')
                      ->setMaxResults(1)
                      ->where('c.flag is Null')
                      ->getQuery()
                      ->getOneOrNullResult();
    }

    //migration 
    public function getCount()
    { 
        return $this->createQueryBuilder('c')->select('count(c.id)')
                      //->setMaxResults(5)
                      //->setFirstResult(11110)
                      ->where('c.flag is Null')
                  //   ->andWhere('c.WYear = 2019')
                      ->getQuery()
                      
                      ->getSingleScalarResult();
    }

    public function getFirstAsArray()
    { 
        return $this->createQueryBuilder('c')
                       ->select('c.id,c.IDClient,c.IDBrand,c.WYear,c.WMonth,c.WHalf,
                                 c.lastUpdatedBy,c.LastUpdatedDate,c.Oferta,c.IDRatio,
                                 c.Folleto,c.Cabecera,c.IDStatus,c.Adicional,c.IDCalidadExp,c.IDCalidadOf,c.KPIQuality,c.flag,
                                 c.NShops,c.NShops0,c.NShops1,c.NShops2,c.NShops3,c.NShops4,c.NShops5,c.NShops6,c.NShops7,c.NShops8,c.NShops9')
                                 ->where('c.flag is NULL')
                                //->andWhere('c.WYear = 2019')
                                ->setMaxResults(1)
                                ->getQuery()
                                ->getOneOrNullResult();
    }
    //migration 
    public function getCount2()
    { 
        return $this->createQueryBuilder('c')->select('count(c.id)')
                      //->setMaxResults(5)
                      //->setFirstResult(11110)
                      ->where('c.flag is Null')
                      ->andWhere("(
                        c.NShops  !='' OR 
                        c.NShops0 !='' OR
                        c.NShops1 !=''  OR
                        c.NShops2 !='' OR 
                        c.NShops3 !='' OR
                        c.NShops4 !='' OR
                        c.NShops5 !='' OR
                        c.NShops6 !='' OR 
                        c.NShops7 !='' OR
                        c.NShops8 !='' OR
                        c.NShops9 !=''
                             )")
                     // ->andWhere('c.WYear = 2009')
                      ->getQuery()
                      
                      ->getSingleScalarResult();
    }

    public function getFirstAsArray2()
    { 
        return $this->createQueryBuilder('c')
                       ->select('c.id,c.IDClient,c.IDBrand,c.WYear,c.WMonth,c.WHalf,
                                 c.lastUpdatedBy,c.LastUpdatedDate,c.Oferta,c.IDRatio,
                                 c.Folleto,c.Cabecera,c.IDStatus,c.Adicional,c.IDCalidadExp,c.IDCalidadOf,c.KPIQuality,c.flag,
                                 c.NShops,c.NShops0,c.NShops1,c.NShops2,c.NShops3,c.NShops4,c.NShops5,c.NShops6,c.NShops7,c.NShops8,c.NShops9')
                                 ->where('c.flag is NULL')
                               //  ->andWhere('c.WYear = 2009')
                               ->andWhere("(
                                c.NShops  !='' OR 
                                c.NShops0 !='' OR
                                c.NShops1 !=''  OR
                                c.NShops2 !='' OR 
                                c.NShops3 !='' OR
                                c.NShops4 !='' OR
                                c.NShops5 !='' OR
                                c.NShops6 !='' OR 
                                c.NShops7 !='' OR
                                c.NShops8 !='' OR
                                c.NShops9 !=''
                                     )")
                                ->setMaxResults(1)
                                ->getQuery()
                                ->getOneOrNullResult();
    }



//end migration
    
    
    public function getone($id)
    {    
        //die("sds");
       // echo $id;die;
        return  $this->createQueryBuilder('c')
                    ->where('c.id = :id')
                    ->setParameter('id',$id)
                    ->getQuery()
                    ->getOneOrNullResult();
    }
}