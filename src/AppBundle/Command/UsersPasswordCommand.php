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
use AppBundle\Entity\UserPassword;

use AppBundle\Entity\RealData;
use AppBundle\Entity\shops;
use Symfony\Component\HttpFoundation\JsonResponse;

class UsersPasswordCommand extends ContainerAwareCommand
{

    
    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('app:migrate-users-password')
       //   ->setName('maintenance:greet')
        // the short description shown while running "php bin/console list"
        ->setDescription('set user psssword')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to set user password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>starts ..</info>'); 
         $doctrine = $this->getContainer()->get('doctrine');
         $em = $doctrine->getEntityManager();

         //get all Empleados rows
         $count= $em->getRepository('AppBundle:User')->getCount();  
         $output->writeln('<info>starts ........</info>'.$count);
        //  foreach ($oldUsers as $key => $row) 
        //  {
            for ($i=0; $i <$count ; $i++) 
            {

                    $user= $em->getRepository('AppBundle:User')->getFirst(); 
                    $output->writeln('<info>starts .......................</info>');
                    if($user)
                    {
                        $output->writeln('<info>starts ........</info>');
                        //$firstName=$user->getFirstName();
                        $range=rand ( 10000 , 99999 );//range(1,6);
                        //$range=implode("",$range);
                        $str='soa'.$user->getId().'@'.$range;
                       // $password=md5($str);
                        $user->setPlainPassword($str);
                        $user->setPassword($str);
                        
                        $user->setEnabled(true);
                        $user->setFlag(1);
                        $em->persist($user);
                        $em->flush();
                        //
                        $newUser=new UserPassword();
                        $newUser->setFirstName($user->getFirstName());
                        $newUser->setLastName($user->getLastName());
                        $newUser->setEmail($user->getEmail());
                        $newUser->setEmailCanonical($user->getEmailCanonical());
                        
                        $newUser->setPassword($str);
                        $em->persist($newUser);
                        $em->flush();

                      $output->writeln('<info>new user ..</info>'.$user->getId());  
                    
                    } 
            
         
            
         }
         $output->writeln('<info>success goood job............update  all users  password done    3ash</info>    ');
        
    }
}