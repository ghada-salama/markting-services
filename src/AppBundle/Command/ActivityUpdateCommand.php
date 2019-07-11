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

class ActivityUpdateCommand extends ContainerAwareCommand
{

    
    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('app:updateActivity')
       //   ->setName('maintenance:greet')
        // the short description shown while running "php bin/console list"
        ->setDescription('update activity  table')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to migarte  a activity  table');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
         $doctrine = $this->getContainer()->get('doctrine');
         $em = $doctrine->getEntityManager();

        
        $q = $em->createQuery('select u from AppBundle:OldActivity u');
        $iterableResult = $q->iterate();
        foreach ($iterableResult as $key=>$row)
        {
          $row=$row[0];
        //$data= $em->getRepository('AppBundle:OldActivity')->getAll();  

          //dump($data);die();
        //   foreach ($data as $key => $row) 
        //   {

           // if($row['flag']==null){
                //get activiy by year and month half and brand and year
               
                $activity=$em->getRepository('AppBundle:Activity')->getActivityById($row['id']);
               if($activity)
               {
                    $client = $em->getRepository('AppBundle:Client')->find($row['IDClient']);
                    $brand = $em->getRepository('AppBundle:Brand')->find($row['IDBrand']);
                   
                   if( $client&&$brand)
                   {

                   

                   //update activity
                   $activity->setClient($client);
                   $activity->setBrand($brand);

                //    $activity->setOffer($row['Oferta']);
                //    $activity->setGama($row['Folleto']);
                //    $activity->setAdditional($row['Adicional']);
                //    $activity->setStatus($row['IDStatus']);
                //    $activity->setKpi($row['KPIQuality']);
                //    $oq=$em->getRepository('AppBundle:OfferQuality')->find($row['IDCalidadOf']);
                //    if($oq)
                //    {
                    
                //      $activity->setExpositionQuality($oq);
                //    }
                   
                //    $eq=$em->getRepository('AppBundle:ExpositionQuality')->find($row['IDCalidadExp']);
                //    if($eq)
                //    {
                //      $activity->setOfferQuality($eq);
                //    }
                //    $ms=$em->getRepository('AppBundle:msImpact')->find($row['IDRatio']);
                //    if($ms)
                //    {
                //        //dump($ms);die();
                //      $activity->setMsImpact($ms);
                //    }

                   $em->persist($activity);
                   $em->flush();
                   $output->writeln('<info>update activity ..</info>'.$key);

                }
               }
             
               
          
        }
        $output->writeln('<info>success goood job............</info>');
    }
}