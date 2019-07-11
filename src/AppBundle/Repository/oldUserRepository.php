<?php

namespace AppBundle\Repository;

/**
 * oldUserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class oldUserRepository extends \Doctrine\ORM\EntityRepository
{

    public function getAll()
    { 
        return $this->createQueryBuilder('c')
                      //->setMaxResults(5)
                     // ->setFirstResult($offset)
                    // ->where('c.IDEmpleado =  210')
                      ->getQuery()
                      ->getArrayResult();
    }

        //migration 
        public function getCount()
        { 
            return $this->createQueryBuilder('c')->select('count(c.IDEmpleado)')
                          //->setMaxResults(5)
                          //->setFirstResult(11110)
                          ->where('c.flag is Null')
                          //->andWhere('c.WYear = 2010')
                          ->getQuery()
                          
                          ->getSingleScalarResult();
        }
    
        public function getFirstAsArray()
        { 
            return $this->createQueryBuilder('c')
                           ->select('c.IDEmpleado,c.nEmpleado,c.apellidosNombre,c.nTUser,c.Apellidos,c.Nombre,
                                     c.Email,c.flag')
                                     ->where('c.flag is NULL')
                                     //->andWhere('c.WYear = 2010')
                                    ->setMaxResults(1)
                                    ->getQuery()
                                    ->getOneOrNullResult();
        }
    
 
    //end migration
}
