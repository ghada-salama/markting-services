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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class BrandType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {  
            $builder->add('name');
            $builder->add('shortName');
            $builder->add('brandOrder');
            $builder->add('siebelCode');       
            $builder->add('imageH');
            $builder->add('Healthcare', CheckboxType::class, array(
                            'label'    => 'Health Care',
                            'required' => false,         
                        ));
            $builder->add('Household', CheckboxType::class, array(
                            'label'    => 'House Hold',
                            'required' => false,         
                        ));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Brand::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ));
    }

}
