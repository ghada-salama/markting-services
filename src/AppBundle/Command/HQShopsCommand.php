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
use AppBundle\Entity\RealData;
use AppBundle\Entity\shops;
use Symfony\Component\HttpFoundation\JsonResponse;

class HQShopsCommand extends ContainerAwareCommand
{

    
    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('app:migrate-hq')
       //   ->setName('maintenance:greet')
        // the short description shown while running "php bin/console list"
        ->setDescription('migrate shops table')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to migarte  a realdata  table');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $first_start=new \DateTime();
         $doctrine = $this->getContainer()->get('doctrine');
         $em = $doctrine->getEntityManager();

        //update id
        //   $data= $em->getRepository('AppBundle:Activity')->getAll();  

        //   //dump($data);die();
        //   $i=44531;
        //   foreach ($data as $key => $row) 
        //   {

        //             $row->setId($row->getOldId());
        //             $em->persist($row);
        //             $em->flush()
        //   }

        //$data= $em->getRepository('AppBundle:OldActivity')->getAll();  
        $count= $em->getRepository('AppBundle:OldActivity')->getCount(); 
          //dump($data);die();
          for ($i=0; $i <$count ; $i++) 
          {
            $start=new \DateTime();
            $row= $em->getRepository('AppBundle:OldActivity')->getFirstASArray();  
            if($row)
            {

            
            if($row['NShops']||$row['NShops0']||$row['NShops1']||$row['NShops2']||$row['NShops3']||$row['NShops4']||$row['NShops5']||$row['NShops6']||$row['NShops7']||$row['NShops8']||$row['NShops9'])
            {

                $activity=$em->getRepository('AppBundle:Activity')->getActivity($row['IDClient'],$row['IDBrand'],$row['WYear'],$row['WMonth'],$row['WHalf']);
               
               //dump($row['IDClient']);die();
                $client = $em->getRepository('AppBundle:Client')->find($row['IDClient']);
                // dump($client);die();
                $brand = $em->getRepository('AppBundle:Brand')->find($row['IDBrand']);
                //dump($brand);die();
               // $em = $this->getDoctrine()->getManager();
                //insert only if exist client and brand 
                if($client && $brand)
                {
                            //die("exist client and brand");
                                //create new acticity if not exist 
                                if(!$activity)
                                {
                                // die("new activty");
                                    $activity=new Activity();
                                    $activity->setClient($client);
                                    $activity->setBrand($brand);
                                    $activity->setWYear($row['WYear']);
                                    $activity->setWMonth($row['WMonth']);
                                    $activity->setWHalf($row['WHalf']);
                                    $em->persist($activity);
                                    $em->flush();
                                    $output->writeln('<info>insert new activity </info>');
                                }
            
                                
                                //insert new row in shops if found brand id and shopsgpv activity id 
                                if($row['NShops']!=0)
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
                                // dump($shops);die();
                                //loop on shops if exist 
                                for ($i=0; $i < 9; $i++) 
                                { 
                                    //get subbrands
                                // dump($row['IDBrand']);die();
                                    $subbrands=$em->getRepository('AppBundle:Brand')->getsubBrandsObj($row['IDBrand']);
                                    
                                    
            
                                    if($row['NShops'.$i]!=0)
                                    {
                                        //
                                        $col='nshops'.$i;
                                        $subbrandName=$em->getRepository('AppBundle:OldBrand')->getSubBrand($col,$row['IDBrand']);
                                        //get id of sub brand by name
                                        $subbrand=$em->getRepository('AppBundle:Brand')->getsubBrandID($subbrandName[$col]);
                                        $shops=new shops();
                                        $shops->setShopsHqValue($row['NShops'.$i]);
                                        $shops->setActivity($activity);
                                        $shops->setBrand($subbrand);
                                        $em->persist($shops);
                                        $em->flush();
                                        $em->clear();
                                        $output->writeln('<info>insert new subbrand hq value </info>');
                                        $em->getConnection()->getConfiguration()->setSQLLogger(null);
                                    }
                                # code...
                                }
                                //insert new shops activity id and get subbrand[shops prefix] 
                        }
                    }
                        //set flag =1 
                    //     $oldDataRow=$em->getRepository('AppBundle:OldActivity')->getone($row['id']);
                    //     //dump($row['id']);die();
                    //    // dump($oldDataRow);die();
                    //     $oldDataRow->setFlag(1);
                    //     $em->persist($shops);
                    //     $em->flush();
                    //    $output->writeln('<info>set flag 1</info>'.$key);
                        $output->writeln('<info>end activity </info>');
                // }
                
                $rowobj= $em->getRepository('AppBundle:OldActivity')->find($row['id']);
               // dump($row['id']);die;  
                $rowobj->setFlag(1);
                $em->persist($rowobj);
                $em->flush();

                $em->clear(); 
                $em->getConnection()->getConfiguration()->setSQLLogger(null);
                $end=new \DateTime();
                $rowDateDif=$end->diff($start);
                $d=$rowDateDif->format("%H:%I:%S");
                $output->writeln('<info>set flag ..</info>'.$d);
            }
        }
        $end_end=new \DateTime();
        $allDateDif=$end_end->diff($first_start);
        $all=$allDateDif->format("%H:%I:%S");
       $output->writeln('<info>success goood job............</info>'.$all);
       
    }
}