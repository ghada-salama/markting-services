<?php

namespace UserBundle\Repository;

/**
 * GroupsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GroupRepository extends \Doctrine\ORM\EntityRepository {
    

    public function getGroupsList($orderBy = false, $sort = 'ASC') {
        $query = $this->createQueryBuilder('g');
        if ($orderBy) {
            $query->orderBy('g.' . $orderBy, $sort);
        }
        return $query->getQuery();
    }
    public function getAllGroups()
    {
       // die("sdsds");
       $query = $this->createQueryBuilder('u');
       $query->where('u.flag != 1');      
       return $query->getQuery();
       //return   $query->getResult();
   }

   public function findByName($name) {
      // echo($name);die();
    $query = $this->createQueryBuilder('u');
    $query->where('u.name = :name');
    $query->setParameter('name', $name);
    $query = $query->getQuery();
   // dump($query->getSql());die();
    return  $query->getOneOrNullResult();
}

public function findById($id) {
    // echo($name);die();
  $query = $this->createQueryBuilder('u');
  $query->where('u.id = :id');
  $query->setParameter('id', $id);
  $query = $query->getQuery();
 // dump($query->getSql());die();
  return  $query->getOneOrNullResult();
}

}
