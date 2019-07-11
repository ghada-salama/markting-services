<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\CallbackTransformer;
use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Entity\Activity;
use AppBundle\Entity\Brand;
use AppBundle\Entity\Client;
use AppBundle\Entity\exposition_quality;
use AppBundle\Entity\header;
use AppBundle\Entity\msImpact;
use AppBundle\Entity\Theme;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ClientType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {  
            $builder->add('name');
            $builder->add('plantTo');
            $builder->add('clientOrder');
           // $builder->add('formActivated');
            $builder->add('imageH');
            $builder->add('maxShops');
            

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Client::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ));
    }

}
