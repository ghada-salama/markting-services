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

class GpvShopsCommand extends ContainerAwareCommand
{

    
    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('app:migrate-gpv')
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
        $output->writeln('<info>start ...........</info>');
         $doctrine = $this->getContainer()->get('doctrine');
         $em = $doctrine->getEntityManager(); 
        $count= $em->getRepository('AppBundle:RealData')->getCount();  
        //dump($count);die;
        for ($i=0; $i <$count ; $i++) 
        {
            
            $start=new \DateTime();
           
            $row= $em->getRepository('AppBundle:RealData')->getFirstAsArray();  
            //dump($row);die;
            if($row)
            {
           // dump($row);die;
            $activity=$em->getRepository('AppBundle:Activity')->getActivity($row['IDClient'],$row['IDBrand'],$row['WYear'],$row['WMonth'],$row['WHalf']);
            //dump($activity);die;
           // dump($activity);die();
            $client = $em->getRepository('AppBundle:Client')->find($row['IDClient']);
            //dump($client);die();
            $brand = $em->getRepository('AppBundle:Brand')->find($row['IDBrand']);
            //dump($brand);die();

            //check if found shops 
            // if($row['NShops']||$row['NShops0']||$row['NShops1']||$row['NShops2']||$row['NShops3']||$row['NShops4']||$row['NShops5']||$row['NShops6']||$row['NShops7']||$row['NShops8']||$row['NShops9'])
            // {
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
                        //$em->clear();
                        $em->getConnection()->getConfiguration()->setSQLLogger(null);
                        $output->writeln('<info>insert new activity </info>'.$i);
                    }

                     //dump($activity);die;
                    //insert new row in shops if found brand id and shopsgpv activity id 
                    // if($row['NShops']!='')
                    // {
                    
                        //get shops my activity id and brand if exist 
                        $shops=$em->getRepository('AppBundle:shops')->getOneShops($brand->getId(),$activity->getId());
                       // dump($shops);die;
                        if(!$shops)
                        {
                            $shops=new shops();
                            $shops->setActivity($activity);
                            $shops->setBrand($brand);
                            $output->writeln('<info>insert new shops</info>');
                        }
                        
                        $shops->setShopsGpvValue($row['NShops']);
                        $em->persist($shops);
                        $em->flush();
                       // $em->clear();
                        $em->getConnection()->getConfiguration()->setSQLLogger(null);
                       
                   // }
                    // dump($shops);die();
                    //loop on shops if exist 
                    for ($i=0; $i < 9; $i++) 
                    { 

                        if(trim($row['NShops'.$i] != ""))
                        {
                            //
                            $col='nshops'.$i;

                            //return brand name 
                            $subbrandName=$em->getRepository('AppBundle:OldBrand')->getSubBrand($col,$row['IDBrand']);

                            //get  brand by name
                            $subbrand=$em->getRepository('AppBundle:Brand')->getsubBrandID($subbrandName[$col]);

                            /*var_dump($row['IDBrand']);
                            var_dump($subbrandName);
                            var_dump($subbrandName[$col]);
                            var_dump($subbrand);
                            
                            die(1);
                            */

                            if ($subbrand){
                                $shops=$em->getRepository('AppBundle:shops')->getOneShops($subbrand->getId(),$activity->getId());
                                //dump($shops);die;
                                if(!$shops)
                                {
                                    $shops=new shops();
                                    $shops->setActivity($activity);
                                    $shops->setBrand($subbrand);
                                    $output->writeln('<info>insert new sub brand shops</info>');
                                }
                                $shops->setShopsGpvValue($row['NShops'.$i]);
                                $em->persist($shops);
                                $em->flush();
                                //$em->clear();
                                $em->getConnection()->getConfiguration()->setSQLLogger(null);
                            }
                            

                        }
                 
                    }
                    //$output->writeln('<info>end activity </info>'.$key);
            }
            $rowobj= $em->getRepository('AppBundle:RealData')->find($row['id']);  
            $rowobj->setFlag(1);
            $em->persist($rowobj);
            $em->flush();
            $em->clear(); 
        //}
    }
         //set old activity flag 1
         //get old real data to set flag
        // dump($row);die;
        
         
         $end=new \DateTime();
         $rowDateDif=$end->diff($start);
         $d=$rowDateDif->format("%H:%I:%S");
         $output->writeln('<info>set flag ..</info>'.$d);
        }
             $end_end=new \DateTime();
            $allDateDif=$end_end->diff($first_start);
            $all=$allDateDif->format("%H:%I:%S");
        $output->writeln('<info>success goood job............</info> time:'.$all.'<info>row count</info> time:'.$count);
    }
}