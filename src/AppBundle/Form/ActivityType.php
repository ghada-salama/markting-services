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

class ActivityType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {  
            $builder->add('offer');
            $builder->add('Status', TextType::class);
            $builder->add('gama', TextType::class);
            $builder->add('additional', TextType::class);
            $builder->add('ms_impact', TextType::class);
            $builder->add('header', TextType::class);
            // $builder->add('header', EntityType::class, array('class' => 'AppBundle:header',
            // 'choice_label' => 'name',
            // 'multiple' => false
            //  ));
            //  $builder->add('msImpact', EntityType::class, array('class' => 'AppBundle:msImpact',
            //  'choice_label' => 'name',
            //  'multiple' => false
            //   ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Activity::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ));
    }

}
