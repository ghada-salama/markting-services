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
use Symfony\Component\HttpFoundation\JsonResponse;

class UsersCommand extends ContainerAwareCommand
{

    
    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('app:migrate-users')
       //   ->setName('maintenance:greet')
        // the short description shown while running "php bin/console list"
        ->setDescription('migrate Empleados table')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to migarte  a Empleados  table');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
         $doctrine = $this->getContainer()->get('doctrine');
         $em = $doctrine->getEntityManager();

         //get all Empleados rows
         $count= $em->getRepository('AppBundle:oldUser')->getCount();  

        //  foreach ($oldUsers as $key => $row) 
        //  {
            for ($i=0; $i <$count ; $i++) 
            {
                    $row= $em->getRepository('AppBundle:oldUser')->getFirstAsArray(); 
                    if($row)
                    {

                        $checkEmil= $em->getRepository('AppBundle:User')->findByEmail($row['Email']); 

                        if($row['Email']!=NULL&&!$checkEmil)
                        {
                    
                                // if($row['nTUser']!=NULL)
                                // {
                                $user=new User();
                                $user->setFirstName($row['Apellidos']);
                                $user->setLastName($row['Nombre']);
                                $user->setUsername($row['Email']);
                
                                $user->setOldId($row['IDEmpleado']);
                                $user->setId($row['IDEmpleado']);
                                $user->setNEmpleado($row['nEmpleado']);
                                $user->setNTUser($row['nTUser']);
                                $user->setEmail($row['Email']);
                                $str=$row['Email'].date("Y-m-d H:i:s");
                                $password=md5($str);
                                $user->setPlainPassword($password);
                                $user->setEnabled(true);
                                //get language
                                
                                $user_lang= $em->getRepository('AppBundle:UserLang')->getUserLang($row['IDEmpleado']); 
                                if($user_lang)
                                {
                                    $lang= $em->getRepository('AppBundle:Lang')->getLang($user_lang->getIdioma()); 
                                    $user->setLangId($lang);
                                }
                                $em->persist($user);
                                $em->flush();
                                
                                
                                //}

                        
                    }
                
                      //SET FLAG 1
                      $rowobj= $em->getRepository('AppBundle:oldUser')->find($row['IDEmpleado']);
                      //dump($rowobj);die;  
                      $rowobj->setFlag(1);
                      $em->persist($rowobj);
                      $em->flush();
                      $em->clear();
                      $output->writeln('<info>new user ..</info>'.$row['IDEmpleado']);  
                    
                    } 
            
         
            
         }
         $output->writeln('<info>success goood job............migrate all users done   you must update id==OLdId 3ash</info>    ');
        
    }
}