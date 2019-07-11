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

class GeneralThemeCommand extends ContainerAwareCommand
{

    
    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('app:migrate-general_themes')
       //   ->setName('maintenance:greet')
        // the short description shown while running "php bin/console list"
        ->setDescription('migrate general theme table')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to migarte  a general theme  table');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
         $doctrine = $this->getContainer()->get('doctrine');
         $em = $doctrine->getEntityManager();

         //get all Empleados rows
         $count= $em->getRepository('AppBundle:OldGeneralTheme')->getCount();  
        //dump($count);die;
        //  foreach ($oldUsers as $key => $row) 
        //  {
            for ($i=0; $i <$count ; $i++) 
            {
                    $row= $em->getRepository('AppBundle:OldGeneralTheme')->getFirstAsArray(); 
                    //dump($row);die;
                    if($row)
                    {

                        $user= $em->getRepository('AppBundle:User')->findUser($row['lastUpdatedBy']); 
                        //dump($user);die;
                        $client = $em->getRepository('AppBundle:Client')->find($row['client_id']);
                        $theme = $em->getRepository('AppBundle:Theme')->find($row['theme_id']);
                        
                        if($client)
                        {
                    
                               
                                $gTheme=new GeneralTheme();
                                $gTheme->setThemeExtraInfo($row['themeExtraInfo']);
                                $gTheme->setWYear($row['wYear']);
                                if($user)
                                {
                                    //dump($user);die();
                                    $gTheme->setLastUpdatedBy($user);
                                }
                               
                                $gTheme->setLastUpdatedDate($row['lastUpdatedDate']);
                                $gTheme->setClientId($client);
                                $gTheme->setWMonth($row['wMonth']);
                                $gTheme->setWHalf($row['wHalf']);
                                $gTheme->setThemeId($theme);
                                $em->persist($gTheme);
                                $em->flush();
                                //dump($gTheme);die;
                                
                           
                        
                    }
                
                      //SET FLAG 1
                      $rowobj= $em->getRepository('AppBundle:OldGeneralTheme')->find($row['id']);
                      //dump($rowobj);die;  
                      $rowobj->setFlag(1);
                      $em->persist($rowobj);
                      $em->flush();
                      $em->clear();
                      $output->writeln('<info>new general theme  ..</info>'.$row['id']);  
                    
                    } 
            
         
            
         }
         $output->writeln('<info>success goood job............</info>    ');
        
    }
}