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
use AppBundle\Entity\setting;

class SettingType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {  
            $builder->add('numberMonth');
            $builder->add('showLastYear');
            $builder->add('elementsInPage');
            $builder->add('theme');
            //$builder->add('header');
            
            $builder->add('nr', TextType::class);
            $builder->add('fc', TextType::class);
            $builder->add('nr_vs_ly', TextType::class);
            $builder->add('realShops', TextType::class);
            $builder->add('totalShops', TextType::class);
            $builder->add('kpi', TextType::class);

            $builder->add('autoSaveActivity', TextType::class);
            $builder->add('widthOfHalf', TextType::class);
            $builder->add('quality', TextType::class);
            $builder->add('themeImageWidth', TextType::class);
            $builder->add('exportExcel', TextType::class);



            $builder->add('itemsPagedLists', TextType::class);
            $builder->add('usersHelpDocument', TextType::class);
            $builder->add('adminHelpDocument', TextType::class);
            $builder->add('buttonsStyle', TextType::class);
            $builder->add('showRatio', TextType::class);



            $builder->add('exposition', TextType::class);
            $builder->add('offeQuality', TextType::class);
            $builder->add('offer', TextType::class);
            $builder->add('gama', TextType::class);
            $builder->add('additional', TextType::class);
 
           
           
            
           
           
           
            
            
            $builder->add('currentYearBgcolor', TextType::class);
            $builder->add('previousYearBgcolor', TextType::class);

            $builder->add('notSelectedReportSelectorColor', TextType::class);
            $builder->add('selectedReportSelectorColor', TextType::class);

            $builder->add('genericActivityColor', TextType::class);

            $builder->add('currentYearOfertaColor', TextType::class);
            $builder->add('lastYearOfertaColor', TextType::class);


            $builder->add('currentYearTiendasColor', TextType::class);
            $builder->add('lastYearTiendasColor', TextType::class);

            $builder->add('currentYearAdicionalColor', TextType::class);
            $builder->add('lastYearAdicionalColor', TextType::class);

            $builder->add('currentYearFolletoColor', TextType::class);
            $builder->add('lastYearFolletoColor', TextType::class);

            $builder->add('currentYearKpiQualityColor', TextType::class);
            $builder->add('lastYearKpiQualityColor', TextType::class);

            $builder->add('currentYearNetRevenueColor', TextType::class);

            $builder->add('currentYearForecastColor', TextType::class);

            $builder->add('currentYearNrVsLyColor', TextType::class);

            $builder->add('lastYearNetRevenueColor', TextType::class);
            
            $builder->add('lastYearForecastColor', TextType::class);

            $builder->add('lastYearNrVsLyColor', TextType::class);

            $builder->add('currentYearThemeColor', TextType::class);

            $builder->add('lastYearThemeColor', TextType::class);

            $builder->add('planificadoForeground', TextType::class);

            $builder->add('cerradoForeground', TextType::class);
            
            

            

            
            

            
            
            
            

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => setting::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ));
    }

}
