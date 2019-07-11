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

class UpdataIDActivityCommand extends ContainerAwareCommand
{

    
    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('app:updateIDActivity')
       //   ->setName('maintenance:greet')
        // the short description shown while running "php bin/console list"
        ->setDescription('seed activity  table')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to migarte  a activity  table');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
         $doctrine = $this->getContainer()->get('doctrine');
         $em = $doctrine->getEntityManager();

        $data= $em->getRepository('AppBundle:Activity')->getAll();  

          //dump($data);die();
          $i=44531;
          foreach ($data as $key => $row) 
          {

                    $row->setId($i);
                    $em->persist($row);
                    $em->flush();
                    $i++;
                  //   $client = $em->getRepository('AppBundle:Client')->find($row['IDClient']);
                  //   $brand = $em->getRepository('AppBundle:Brand')->find($row['IDBrand']);
                   
                  //  if( $client&&$brand)
                  //  {

                  //   $output->writeln('<info>update activity ..</info>'.$row['id']);
                  //   $activity=new Activity();
                   
                  //  $activity->setOldId($row['id']);
                  //  $activity->setClient($client);
                  //  $activity->setBrand($brand);

                  //  $activity->setWYear($row['WYear']);
                  //  $activity->setWMonth($row['WMonth']);
                  //  $activity->setWHalf($row['WHalf']);

                  
                   
                   
                  //  $activity->setOffer($row['Oferta']);
                  //  $activity->setGama($row['Folleto']);
                  //  $activity->setAdditional($row['Adicional']);
                  //  $activity->setStatus($row['IDStatus']);

                  //  if($row['KPIQuality']!=-1)
                  //  {
                  //   $activity->setKpi($row['KPIQuality']);
                  //  }
                   
                  //  $oq=$em->getRepository('AppBundle:OfferQuality')->find($row['IDCalidadOf']);
                  //  if($oq)
                  //  {
                  //  // $output->writeln('<info>oq ..</info>'.$oq);
                  //    $activity->setExpositionQuality($oq);
                  //  }
                   
                  //  $eq=$em->getRepository('AppBundle:ExpositionQuality')->find($row['IDCalidadExp']);
                  //  if($eq)
                  //  {
                  //  // $output->writeln('<info>eq ..</info>'.$eq);
                  //    $activity->setOfferQuality($eq);
                  //  }
                  //  $ms=$em->getRepository('AppBundle:msImpact')->find($row['IDRatio']);
                  //  if($ms)
                  //  {
                  //      //dump($ms);die();
                  //   // $output->writeln('<info>ms ..</info>'.$ms);
                  //    $activity->setMsImpact($ms);
                  //  }

                  //  $em->persist($activity);
                  //  $em->flush();
                   $output->writeln('<info>new activity ..</info>'.$key);

                }
               
             
                $output->writeln('<info>success goood job............</info>');
          
        }
       
    
}