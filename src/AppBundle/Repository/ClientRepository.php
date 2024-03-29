<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * ClientRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClientRepository extends \Doctrine\ORM\EntityRepository
{
    
    public function getClients()
    {
        
        $query = $this->createQueryBuilder('c');
                // $query->select('c.id,c.name,c.clientOrder,c.imageH,c.plantTo');
                 $query->where('c.flag !=  1');
                 $query->orderBy('c.clientOrder');
                 $query = $query->getQuery();
        return $query->getArrayResult();
       
        
    }

 
    public function getClientsById($ids)
    {
        
        $query = $this->createQueryBuilder('c');
                // $query->select('c.id,c.name,c.clientOrder,c.imageH');
                 $query->where('c.flag !=  1');
                 $query->Where('c.id in (:id)');
                 $query->setParameter('id',$ids);
                 // TO DO search about where in syntax doctrine symfony 
                // $query->where(c.id);
                 $query = $query->getQuery();
        return   $query->getArrayResult();
    }

    public function getClientsOrderByName()
    {
        //die("xxx");
        $query = $this->createQueryBuilder('c');
                 //$query->select('c.id,c.name,c.clientOrder,c.imageH,c.plantTo,c.imageUrl');
                 $query->where('c.flag !=  1');
                 $query->orderBy('c.name');
                 $query = $query->getQuery();
        return $query->getArrayResult();
       
        
    }
    public function getClientsNameExport()
    {
        //die("xxx");
        $query = $this->createQueryBuilder('c');
                 //$query->select('c.id,c.name,c.clientOrder,c.imageH,c.plantTo,c.imageUrl');
                 $query->where('c.flag !=  1');
                 $query->orderBy('c.name');
                 $query = $query->getQuery();
        return $query->getResult();
       
        
    }

    public function getClientsOrderBy($ids,$oder)
    {
       // dump($ids);die;
        //die("xxx");
        $query = $this->createQueryBuilder('c');
                 //$query->select('c.id,c.name,c.clientOrder,c.imageH,c.plantTo,c.imageUrl');
                 
                 if($oder=='name')
                 {
                    $query->orderBy('c.name');
                 }else{
                    $query->orderBy('c.clientOrder');
                 }

                
                 $query->where('c.flag !=  1');
                 if(count($ids))
                 {
                    $query->andWhere('c.id in  (:ids)');
                    $query->setParameter('ids', $ids);
   
                 }
                 $query = $query->getQuery();

        return $query->getResult();
       
        
    }

    public function getListClientsOrderBy($oder)
    {
       // dump($ids);die;
        //die("xxx");
        $query = $this->createQueryBuilder('c');
                 //$query->select('c.id,c.name,c.clientOrder,c.imageH,c.plantTo,c.imageUrl');
                 
                 if($oder=='name')
                 {
                    $query->orderBy('c.name');
                 }else{
                    $query->orderBy('c.clientOrder');
                 }
                
                 $query->where('c.flag !=  1');
                 $query = $query->getQuery();

        return $query->getResult();
       
        
    }

    public function getClientsOrderByNameById($ids)
    {
        
        $query = $this->createQueryBuilder('c');
                //$query->select('c.id,c.name,c.clientOrder,c.imageH');
                 $query->where('c.flag !=  1');
                 $query->Where('c.id in (:id)');
                 $query->setParameter('id',$ids);
                 $query->orderBy('c.name');;
                 $query = $query->getQuery();
        return   $query->getArrayResult();
    }

    public function getClientsExport($ids)
    {
        
        $query = $this->createQueryBuilder('c');
                //$query->select('c.id,c.name,c.clientOrder,c.imageH');
                 $query->where('c.flag !=  1');
                 $query->Where('c.id in (:id)');
                 $query->setParameter('id',$ids);
                 $query->orderBy('c.clientOrder');
                 $query = $query->getQuery();
        return   $query->getResult();
    }
       //findWhereIn
       public function getClientsObjectById($ids)
       {
           
           $query = $this->createQueryBuilder('c');
                    $query->where('c.flag !=  1');
                   // $query->select('c.id,c.name,c.clientOrder,c.imageH');
                    $query->Where('c.id in (:id)');
                    $query->setParameter('id',$ids);
                    // TO DO search about where in syntax doctrine symfony 
                   // $query->where(c.id);
                    $query = $query->getQuery();
           return   $query->getResult();
       }


    


    public function getGrid($client_id,$filters)
    { 
    $result=[];
        $query = $this->createQueryBuilder('c');
                 $query->select('c.id,c.name,c.clientOrder,c.imageH');
                 $query->where('c.id=  :id');
                 $query->setParameter('id', $client_id);
                 $query->where('c.flag !=  1');
        $query = $query->getQuery();
        $client= $query->getOneOrNullResult();

        //get client details
        
        $brands=[];
        if(!count($filters['brands'])==0)
        { 
            $brands=$this->getEntityManager()->getRepository('AppBundle:Brand')->getBrandsById($filters['brands']);;
        }else
        {
            //all_brands and all_clientd mode
            $brands=$this->getEntityManager()->getRepository('AppBundle:Brand')->getBrands();
        }

        $result['clients']['data']= $this->getEntityManager()->getRepository('AppBundle:Activity')->getTitlesList($brands,$filters);
        $result['clients']['name']=$client['name'];
        $result['clients']['value']=$client['id'];
        $result['clients']['imageH']=$client['imageH'];
        return $result;      
        
    }

    public function getClientDetails($client_id,$filters)
    { 
       
        $query = $this->createQueryBuilder('c');
                 $query->select('c.id,c.name,c.clientOrder,c.imageH');
                 $query->where('c.id=  :id');
                 $query->setParameter('id', $client_id);

        $query = $query->getQuery();
        $brands=[];
        if(!count($filters['brands'])==0)
        { 
            $brands=$this->getEntityManager()->getRepository('AppBundle:Brand')->getBrandsById($filters['brands']);;
        }else
        {
            //all_brands and all_clientd mode
            $brands=$this->getEntityManager()->getRepository('AppBundle:Brand')->getBrands();
        }

        $result=$this->getEntityManager()->getRepository('AppBundle:Activity')->getActivitesList($client_id,$brands,$filters);
        return $result;      
        
    }

    //get activits in all brands group by year
    public function getClientActivities($client_id,$filters)
    {
        
        $brands=[];
        if(!count($filters['brands'])==0)
        { 
            
            $brands=$this->getEntityManager()->getRepository('AppBundle:Brand')->getBrandsById($filters['brands']);;
        }else
        {
            //all_brands and all_clientd mode
            $brands=$this->getEntityManager()->getRepository('AppBundle:Brand')->getBrands();
        }
        
        //dump($filters['brands']);die();
        //loop on brands and get list of activities
        $result=[];
       // dump($brands);die();
        foreach ($brands as  $brand) {
            //echo $brand;die();
            //get all activity in each year
            $year=$filters['year'];
            $result[$filters['year']][]=$this->getEntityManager()->getRepository('AppBundle:Activity')->getActivities($client_id,$brand['id'],$filters,$year);
            
            if($filters['show_last_year'])
            {
                $year=$filters['year']-1;
                $result[$year][]=$this->getEntityManager()->getRepository('AppBundle:Activity')->getActivities($client_id,$brand['id'],$filters,$year);
            }
        }
  
        return $result;
        
    }

    // public function getClients()
    // {
        
    //     $query = $this->createQueryBuilder('b');
    //              $query->select('b.id,b.name,b.brandOrder,b.imageH');
    //              $query = $query->getQuery();
    //     return $query->getResult();
    
        
    // }
    // public function getsclientsById($ids)
    // {
        
    //     $query = $this->createQueryBuilder('b');
    //              $query->select('b.id,b.name,b.brandOrder,b.imageH');
    //              $query->Where('b.id in (:id)');
    //              $query->setParameter('id',$ids);
    //              $query = $query->getQuery();
    //     return $query->getResult();
    // }
    
}
