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
use AppBundle\Entity\User;
use AppBundle\Entity\RealData;
use AppBundle\Entity\shops;
use AppBundle\Entity\GeneralTheme;
use AppBundle\Entity\Theme;
use Symfony\Component\HttpFoundation\JsonResponse;

class ThemeCommand extends ContainerAwareCommand
{

    
    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('app:migrate-themes')
       //   ->setName('maintenance:greet')
        // the short description shown while running "php bin/console list"
        ->setDescription('migrate theme table')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to migarte  a theme  table');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
         $doctrine = $this->getContainer()->get('doctrine');
         $em = $doctrine->getEntityManager();

         //get all Empleados rows
         $count= $em->getRepository('AppBundle:oldTheme')->getCount();  

        //  foreach ($oldUsers as $key => $row) 
        //  {
            for ($i=0; $i <$count ; $i++) 
            {
                    $row= $em->getRepository('AppBundle:oldTheme')->getFirstAsArray(); 
                    
                    if($row)
                    {

                        $user= $em->getRepository('AppBundle:User')->findUser($row['LastUpdatedBy']); 
                       // dump($user);die;
                        $client = $em->getRepository('AppBundle:Client')->find($row['IDClient']);
                        if( $client)
                        {
                    
                               
                                $gTheme=new Theme();
                                $gTheme->setName($row['Name']);
                                $gTheme->setImageH($row['ImageFileName']);
                                if($user)
                                {
                                    $gTheme->setLastUpdatedBy($user);
                                }
                               
                                $gTheme->setLastUpdatedAt($row['LastUpdatedDate']);
                                $gTheme->setClient($client);
                                $gTheme->setFlag($row['indBaja']);
                                $em->persist($gTheme);
                                $em->flush();
                                
                           
                        
                    }
                
                      //SET FLAG 1
                      $rowobj= $em->getRepository('AppBundle:oldTheme')->find($row['id']);
                      //dump($rowobj);die;  
                      $rowobj->setFlag(1);
                      $em->persist($rowobj);
                      $em->flush();
                      $em->clear();
                      $output->writeln('<info>new theme ..</info>'.$row['id']);  
                    
                    } 
            
         
            
         }
         $output->writeln('<info>success goood job............</info>    ');
        
    }
}