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
use AppBundle\Entity\Group;
use AppBundle\Entity\RealData;
use AppBundle\Entity\shops;
use Symfony\Component\HttpFoundation\JsonResponse;

class GroupsCommand extends ContainerAwareCommand
{

    
    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('app:migrate-Groups')
       //   ->setName('maintenance:greet')
        // the short description shown while running "php bin/console list"
        ->setDescription('migrate Groups table')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to migarte  a Groups  table');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
         $doctrine = $this->getContainer()->get('doctrine');
         $em = $doctrine->getEntityManager();

         //insert three static group
         $groups=[
                    [
                        'name' =>'Administrators',
                        'roles'=>['ROLE_USER','ROLE_SUPER_ADMIN'],//'a:2:{i:0;s:9:"ROLE_USER";i:1;s:16:"ROLE_SUPER_ADMIN";}',
                        'observaciones'=>'Administradores',
                        'flag'=>true,
                    ],
                    [
                        'name' =>'Input Data',
                        'roles'=>['ROLE_USER','ROLE_HQ_ADMIN'],
                        'observaciones'=>'Usuarios que pueden introducir los datos de Número de tiendas y % Cumplimiento REALES',
                        'flag'=>true,
                    ],
                    [
                        'name' =>'Valoración',
                        'roles'=>['ROLE_USER','ROLE_GPV_ADMIN'],//'a:2:{i:0;s:9:"ROLE_USER";i:1;s:14:"ROLE_GPV_ADMIN";}',
                        'observaciones'=>'Usuarios que pueden VALORAR la calidad de la exposición y de la oferta',
                        'flag'=>true,
                    ]
        ];
        foreach ($groups as $key => $group) {

            $groupobj=new Group();
            $groupobj->setName($group['name']);
            $groupobj->setRoles($group['roles']);
            $groupobj->setObservaciones($group['observaciones']);
            $groupobj->setFlag($group['flag']);
            $em->persist($groupobj);
            $em->flush();
            $output->writeln('<info>new group ..</info>'.$key);
        }
         
         $output->writeln('<info>success goood job............migrate all groups done   you must group id=0  to id=1in usergroup </info>    ');
        
    }
}