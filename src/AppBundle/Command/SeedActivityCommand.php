<?php

// src/AppBundle/Command/migarteClient.php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Client;
use AppBundle\Entity\Brand;
use AppBundle\Entity\Activity;
use AppBundle\Entity\header;
use AppBundle\Entity\RealData;
use AppBundle\Entity\shops;
use Symfony\Component\HttpFoundation\JsonResponse;

class SeedActivityCommand extends ContainerAwareCommand
{

    
    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('app:seedActivity')
       //   ->setName('maintenance:greet')
        // the short description shown while running "php bin/console list"
        ->setDescription('seed activity  table')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to migarte  a activity  table');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    //  $flag=1;
      $output->writeln('start seed Activity .........................');
      $first_start=new \DateTime();
      $doctrine = $this->getContainer()->get('doctrine');
      $em = $doctrine->getEntityManager();

        $count= $em->getRepository('AppBundle:OldActivity')->getCount();  

          // $years=range(2008,2019);
          // foreach ($years as $key => $year) 
          // {
                // $q = $em->createQuery('select u  from AppBundle:OldActivity u where u.WYear = :WYear')->setParameter('WYear',$year);
                // $iterableResult = $q->iterate();

                // foreach ($iterableResult as $key=>$row) 
                //$start=new \DateTime();
                $batchSize = 20;
                for ($i=0; $i <$count ; $i++) 
                {
                        $start=new \DateTime();
                        $row= $em->getRepository('AppBundle:OldActivity')->getFirstAsArray();  
                       // dump($row);die;
                        if($row)
                        {
                            $client = $em->getRepository('AppBundle:Client')->find($row['IDClient']);
                            $brand = $em->getRepository('AppBundle:Brand')->find($row['IDBrand']);
                            
                            if( $client&&$brand)
                            {
                                $flag=1;
                                $output->writeln('<info>old id  activity ..</info>'.$row['id']);
                                $activity=new Activity();
                                $activity->setOldId($row['id']);
                                $activity->setId($row['id']);
                                
                                $activity->setClient($client);
                                $activity->setBrand($brand);
                                $activity->setWYear($row['WYear']);
                                $activity->setWMonth($row['WMonth']);
                                $activity->setWHalf($row['WHalf']);
                                $activity->setOffer($row['Oferta']);
                                $activity->setGama($row['Folleto']);
                                $activity->setAdditional($row['Adicional']);
                                $activity->setStatus($row['IDStatus']);

                                //$activity->setLastUpdateAt($row->getLastUpdatedDate()->format('Y-m-d H:i:s'));]
                                $activity->setLastUpdatedAt($row['LastUpdatedDate']);
                                
                                //last updated by
                                //check if user found or set null
                                $user=$row['lastUpdatedBy'];
                                if($user)
                                {
                                  $userObj=$em->getRepository('AppBundle:User')->find($user);
                                  if($userObj)
                                  {
                                    $activity->setLastUpdatedBy($userObj);
                                  }

                                }
                                if($row['KPIQuality']!=-1)
                                {
                                  $activity->setKpi($row['KPIQuality']);
                                }

                              
                                
                                $oq=$em->getRepository('AppBundle:OfferQuality')->find($row['IDCalidadOf']);
                                if($oq)
                                {
                                  $activity->setOfferQuality($oq);
                                }
                                
                                $eq=$em->getRepository('AppBundle:ExpositionQuality')->find($row['IDCalidadExp']);
                                if($eq)
                                {
                                  $activity->setExpositionQuality($eq);
                                }
                                $ms=$em->getRepository('AppBundle:msImpact')->find($row['IDRatio']);
                                if($ms)
                                {
                                  $activity->setMsImpact($ms);
                                }

                                //get header id if found or insert new header and return header id 
                                  $header=trim($row['Cabecera']);
                                  if($header)
                                  {
                                    //check if found in header table
                                    $headerObj=$em->getRepository('AppBundle:header')->getByName($header);
                                    if(!$headerObj)
                                    {
                                      //insert new header
                                      $h=new header();
                                      $h->setName($header);
                                      $h->setLastUpdatedAt(new \DateTime());
                                      $em->persist($h);
                                      $em->flush();
                                      //$em->clear();
                                      $activity->setHeader($h);
                                    }else{
                                      $activity->setHeader($headerObj);
                                    }

                                  }
                                //Cabecera ==header
                                $em->persist($activity);
                                $em->flush();
                              // $em->clear();


                                //insert new row in shops if found brand id and shopsgpv activity id 
                                if($row['NShops']!='')
                                {
                                // dump($activity);die();
                                    $shops=new shops();
                                    $shops->setShopsHqValue($row['NShops']);
                                    $shops->setActivity($activity);
                                    $shops->setBrand($brand);
                                    $em->persist($shops);
                                    $em->flush();
                                    $output->writeln('<info>insert new brand hq value </info>');
                                }
                                //loop on shops if exist 
                                for ($i=0; $i < 9; $i++) 
                                { 
                                    //get subbrands
                                // dump($row['IDBrand']);die();
                                    $subbrands=$em->getRepository('AppBundle:Brand')->getsubBrandsObj($row['IDBrand']);
                                    
                                    
            
                                    if($row['NShops'.$i]!='')
                                    {
                                        //
                                        $col='nshops'.$i;
                                        $subbrandName=$em->getRepository('AppBundle:OldBrand')->getSubBrand($col,$row['IDBrand']);
                                        if($subbrandName)
                                        {
                                            //get id of sub brand by name
                                            $subbrand=$em->getRepository('AppBundle:Brand')->getsubBrandID($subbrandName[$col]);
                                            if($subbrand)
                                            {
                                              $shops=new shops();
                                              $shops->setShopsHqValue($row['NShops'.$i]);
                                              $shops->setActivity($activity);
                                              $shops->setBrand($subbrand);
                                              $em->persist($shops);
                                              $em->flush();
                                              // $em->clear();
                                              $output->writeln('<info>insert new subbrand hq value </info>');
                                              $em->getConnection()->getConfiguration()->setSQLLogger(null);
                                            }
                                            
                                        }
                                       
                                    }
                                # code...
                                }

                                $em->getConnection()->getConfiguration()->setSQLLogger(null);
                                $end=new \DateTime();
                                $rowDateDif=$end->diff($start);
                                $d=$rowDateDif->format("%H:%I:%S");
                                $output->writeln('<info>new activity ..</info>'.$d);
                                

                          
                          }
                          //SET FLAG 1
                          $rowobj= $em->getRepository('AppBundle:OldActivity')->find($row['id']);
                          //dump($rowobj);die;  
                          $rowobj->setFlag(1);
                          $em->persist($rowobj);
                          $em->flush();
                          $em->clear();
                    }
                    
          
                
              }
             // $output->writeln('<info>end year ............................................................................</info>'.$year);
           // }
            $end_end=new \DateTime();
            $allDateDif=$end_end->diff($first_start);
            $all=$allDateDif->format("%H:%I:%S");
            $output->writeln('<info>success goood job............ 1- remove year filter 2-set activity is auto generate </info>'.$all.'count:'.$count);
    }
}