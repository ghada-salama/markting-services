<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSSerializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Required;

/**
 * setting
 *
 * @ORM\Table(name="setting")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\settingRepository")
 */
class setting
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSSerializer\Groups({"setting_component"})
     */
    private $id;


    /**
     * @var int
     *
     * @ORM\Column(name="numberMonth", type="string",nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("number_month")
     */
    private $numberMonth=12;

    /**
     * @var int
     *
     * @ORM\Column(name="showLastYear", type="string",nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("show_last_year")
     */
    private $showLastYear=0;

    /**
     * @var int
     *
     * @ORM\Column(name="elementsInPage", type="string",nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("itemsPagedLists")
     */
    private $elementsInPage=20;

    /**
     * @var int
     *
     * @ORM\Column(name="theme", type="string",nullable=true)
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\Groups({"setting_component","grid_setting_component"})
     */
    private $theme=1;

     /**
     * @var int
     *
     * @JMSSerializer\SerializedName("offer")
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\Groups({"grid_setting_component"})
     */
    private $offer=1;

    /**
     * @var int
     * @JMSSerializer\SerializedName("gama")
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\Groups({"grid_setting_component"})
     */
    private $gama=1;


    /**
     * @var int

     * @JMSSerializer\SerializedName("header")
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\Groups({"grid_setting_component"})
     */
    private $header=1;

    /**
     * @var int

     * @JMSSerializer\SerializedName("hq_shops")
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\Groups({"grid_setting_component"})
     */
    private $hq_shops=1;

    /**
     * @var int
     *
     * @ORM\Column(name="additional", type="string",nullable=true)

     * @JMSSerializer\Groups({"grid_setting_component"})
     */
    private $additional=1;

    /**
     * @var int
     *
     * @ORM\Column(name="kpi", type="string",nullable=true)
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\Groups({"grid_setting_component","setting_component"})
     */
    private $kpi=1;

        /**
     * @var int
     *
     * @ORM\Column(name="exposition", type="string",nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\Groups({"grid_setting_component"})
     */
    private $exposition=1;

    /**
     * @var int
     *
     * @ORM\Column(name="offerQuality", type="string",nullable=true)
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\Groups({"grid_setting_component"})
     */
    private $offeQuality=1;


    /**
     * @var int
     * @JMSSerializer\SerializedName("gpv_shops")
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\Groups({"grid_setting_component"})
     */
    private $gpv_shops=1;

    /**
     * @var int
     *
     * @ORM\Column(name="totalShops", type="string",nullable=true)
     * @JMSSerializer\Groups({"setting_component","grid_setting_component"})
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\SerializedName("total_shops")
     */
    private $totalShops=1;

        /**
     * @var int
     *
     * @ORM\Column(name="nr", type="string",nullable=true)
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\Groups({"grid_setting_component","setting_component"})
     */
    private $nr=0;

    /**
     * @var int
     *
     * @ORM\Column(name="fc", type="string",nullable=true)
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\Groups({"grid_setting_component","setting_component"})
     */
    private $fc=0;

    /**
     * @var int
     *
     * @ORM\Column(name="nrVsLy", type="string",nullable=true)
     * @JMSSerializer\Type("integer")
     * @JMSSerializer\Groups({"grid_setting_component","setting_component"})
     */
    private $nr_vs_ly=0;




   /**
     * @var int
     *
     * @ORM\Column(name="realshops", type="string",nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("real_shops")
     */
    private $realShops=1;




    /**
     * @var int
     *
     * @ORM\Column(name="autoSaveActivity", type="string",nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("autoSaveActivity")
     */
    private $autoSaveActivity=0;

    /**
     * @var int
     *
     * @ORM\Column(name="widthOfHalf", type="string",nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("widthOfHalf")
     */
    private $widthOfHalf=80;

    /**
     * @var int
     *
     * @ORM\Column(name="quality", type="string",nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     */
    private $quality=0;

    /**
     * @var int
     *
     * @ORM\Column(name="themeImageWidth", type="string",nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("themeImageWidth")
     */
    private $themeImageWidth=80;

    /**
     * @var int
     *
     * @ORM\Column(name="exportExcel", type="string",nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("exportExcel")
     */
    private $exportExcel=0;

    /**
     * @var int
     *
     * @ORM\Column(name="itemsPagedLists", type="string",nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("itemsPagedLists")
     */
    private $itemsPagedLists=20;

    /**
     * @var string
     *
     * @ORM\Column(name="usersHelpDocument", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("usersHelpDocument")
     */
    private $usersHelpDocument;

    

    /**
     * @var string
     *
     * @ORM\Column(name="adminHelpDocument", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("adminHelpDocument")
     */
    private $adminHelpDocument;

    /**
     * @var int
     *
     * @ORM\Column(name="buttonsStyle", type="string",nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("buttonsStyle")
     */
    private $buttonsStyle=0;


      /**
     * @var int
     *
     * @ORM\Column(name="showRatio", type="string",nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("showRatio")
     */
    private $showRatio=0;

    /**
     * @var string
     *
     * @ORM\Column(name="currentYearBgcolor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("currentYearBgcolor")
     */
    private $currentYearBgcolor;


    /**
     * @var string
     *
     * @ORM\Column(name="previousYearBgcolor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
    * @JMSSerializer\SerializedName("previousYearBgcolor")
     */
    private $previousYearBgcolor;


    /**
     * @var string
     *
     * @ORM\Column(name="selectedReportSelectorColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("selectedReportSelectorColor")
     */
    private $selectedReportSelectorColor;

    /**
     * @var string
     *
     * @ORM\Column(name="notSelectedReportSelectorColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("notSelectedReportSelectorColor")
     */
    private $notSelectedReportSelectorColor;

    /**
     * @var string
     *
     * @ORM\Column(name="genericActivityColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("genericActivityColor")
     */
    private $genericActivityColor;

    /**
     * @var string
     *
     * @ORM\Column(name="currentYearOfertaColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("currentYearOfertaColor")
     */
    private $currentYearOfertaColor;

    /**
     * @var string
     *
     * @ORM\Column(name="lastYearOfertaColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("lastYearOfertaColor")
     */
    private $lastYearOfertaColor;

    /**
     * @var string
     *
     * @ORM\Column(name="currentYearTiendasColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("currentYearTiendasColor")
     */
    private $currentYearTiendasColor;


    /**
     * @var string
     *
     * @ORM\Column(name="lastYearTiendasColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("lastYearTiendasColor")
     */
    private $lastYearTiendasColor;


    /**
     * @var string
     *
     * @ORM\Column(name="currentYearAdicionalColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("currentYearAdicionalColor")
     */
    private $currentYearAdicionalColor;


    /**
     * @var string
     *
     * @ORM\Column(name="lastYearAdicionalColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("lastYearAdicionalColor")
     */
    private $lastYearAdicionalColor;

    /**
     * @var string
     *
     * @ORM\Column(name="currentYearFolletoColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("currentYearFolletoColor")
     */
    private $currentYearFolletoColor;


    /**
     * @var string
     *
     * @ORM\Column(name="lastYearFolletoColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("lastYearFolletoColor")
     */
    private $lastYearFolletoColor;

        /**
     * @var string
     *
     * @ORM\Column(name="currentYearKpiQualityColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("currentYearKpiQualityColor")
     */
    private $currentYearKpiQualityColor;


    /**
     * @var string
     *
     * @ORM\Column(name="lastYearKpiQualityColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("lastYearKpiQualityColor")
     */
    private $lastYearKpiQualityColor;


    /**
     * @var string
     *
     * @ORM\Column(name="currentYearNetRevenueColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("currentYearNetRevenueColor")
     */
    private $currentYearNetRevenueColor;

    /**
     * @var string
     *
     * @ORM\Column(name="currentYearForecastColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("currentYearForecastColor")
     */
    private $currentYearForecastColor;

     /**
     * @var string
     *
     * @ORM\Column(name="currentYearNrVsLyColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("currentYearNrVsLyColor")
     */
    private $currentYearNrVsLyColor;

     /**
     * @var string
     *
     * @ORM\Column(name="lastYearNetRevenueColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("lastYearNetRevenueColor")
     */
    private $lastYearNetRevenueColor;

    /**
     * @var string
     *
     * @ORM\Column(name="lastYearForecastColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("lastYearForecastColor")
     */
    private $lastYearForecastColor;

  /**
     * @var string
     *
     * @ORM\Column(name="lastYearNrVsLyColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("lastYearNrVsLyColor")
     */
    private $lastYearNrVsLyColor;


    /**
     * @var string
     *
     * @ORM\Column(name="currentYearThemeColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("currentYearThemeColor")
     */
    private $currentYearThemeColor;

    /**
     * @var string
     *
     * @ORM\Column(name="lastYearThemeColor", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("lastYearThemeColor")
     */
    private $lastYearThemeColor;

    /**
     * @var string
     *
     * @ORM\Column(name="planificadoForeground", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("planificadoForeground")
     */
    private $planificadoForeground;

    
    /**
     * @var string
     *
     * @ORM\Column(name="cerradoForeground", type="string", length=255,nullable=true)
     * @JMSSerializer\Groups({"setting_component"})
     * @JMSSerializer\SerializedName("cerradoForeground")
     */
    private  $cerradoForeground;

    


    

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numberMonth
     *
     * @param string $numberMonth
     *
     * @return setting
     */
    public function setNumberMonth($numberMonth)
    {
        $this->numberMonth = $numberMonth;

        return $this;
    }

    /**
     * Get numberMonth
     *
     * @return string
     */
    public function getNumberMonth()
    {
        return $this->numberMonth;
    }

    /**
     * Set showLastYear
     *
     * @param string $showLastYear
     *
     * @return setting
     */
    public function setShowLastYear($showLastYear)
    {
        $this->showLastYear = $showLastYear;

        return $this;
    }

    /**
     * Get showLastYear
     *
     * @return string
     */
    public function getShowLastYear()
    {
        return $this->showLastYear;
    }

    /**
     * Set elementsInPage
     *
     * @param string $elementsInPage
     *
     * @return setting
     */
    public function setElementsInPage($elementsInPage)
    {
        $this->elementsInPage = $elementsInPage;

        return $this;
    }

    /**
     * Get elementsInPage
     *
     * @return string
     */
    public function getElementsInPage()
    {
        return $this->elementsInPage;
    }

    /**
     * Set theme
     *
     * @param string $theme
     *
     * @return setting
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set offer
     *
     * @param string $offer
     *
     * @return setting
     */
    public function setOffer($offer)
    {
        $this->offer = $offer;

        return $this;
    }

    /**
     * Get offer
     *
     * @return string
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * Set gama
     *
     * @param string $gama
     *
     * @return setting
     */
    public function setGama($gama)
    {
        $this->gama = $gama;

        return $this;
    }

    /**
     * Get gama
     *
     * @return string
     */
    public function getGama()
    {
        return $this->gama;
    }

  



    /**
     * Set additional
     *
     * @param string $additional
     *
     * @return setting
     */
    public function setAdditional($additional)
    {
        $this->additional = $additional;

        return $this;
    }

    /**
     * Get additional
     *
     * @return string
     */
    public function getAdditional()
    {
        return $this->additional;
    }

    /**
     * Set kpi
     *
     * @param string $kpi
     *
     * @return setting
     */
    public function setKpi($kpi)
    {
        $this->kpi = $kpi;

        return $this;
    }

    /**
     * Get kpi
     *
     * @return string
     */
    public function getKpi()
    {
        return $this->kpi;
    }

    /**
     * Set exposition
     *
     * @param string $exposition
     *
     * @return setting
     */
    public function setExposition($exposition)
    {
        $this->exposition = $exposition;

        return $this;
    }

    /**
     * Get exposition
     *
     * @return string
     */
    public function getExposition()
    {
        return $this->exposition;
    }

    /**
     * Set offeQuality
     *
     * @param string $offeQuality
     *
     * @return setting
     */
    public function setOffeQuality($offeQuality)
    {
        $this->offeQuality = $offeQuality;

        return $this;
    }

    /**
     * Get offeQuality
     *
     * @return string
     */
    public function getOffeQuality()
    {
        return $this->offeQuality;
    }

    /**
     * Set realShops
     *
     * @param string $realShops
     *
     * @return setting
     */
    public function setRealShops($realShops)
    {
        $this->realShops = $realShops;

        return $this;
    }

    /**
     * Get realShops
     *
     * @return string
     */
    public function getRealShops()
    {
        return $this->realShops;
    }

    /**
     * Set totalShops
     *
     * @param string $totalShops
     *
     * @return setting
     */
    public function setTotalShops($totalShops)
    {
        $this->totalShops = $totalShops;

        return $this;
    }

    /**
     * Get totalShops
     *
     * @return string
     */
    public function getTotalShops()
    {
        return $this->totalShops;
    }

    /**
     * Set nr
     *
     * @param string $nr
     *
     * @return setting
     */
    public function setNr($nr)
    {
        $this->nr = $nr;

        return $this;
    }

    /**
     * Get nr
     *
     * @return string
     */
    public function getNr()
    {
        return $this->nr;
    }

    /**
     * Set fc
     *
     * @param string $fc
     *
     * @return setting
     */
    public function setFc($fc)
    {
        $this->fc = $fc;

        return $this;
    }

    /**
     * Get fc
     *
     * @return string
     */
    public function getFc()
    {
        return $this->fc;
    }

    /**
     * Set nrVsLy
     *
     * @param string $nrVsLy
     *
     * @return setting
     */
    public function setNrVsLy($nrVsLy)
    {
        $this->nr_vs_ly = $nrVsLy;

        return $this;
    }

    /**
     * Get nrVsLy
     *
     * @return string
     */
    public function getNrVsLy()
    {
        return $this->nr_vs_ly;
    }

    /**
     * Set autoSaveActivity
     *
     * @param string $autoSaveActivity
     *
     * @return setting
     */
    public function setAutoSaveActivity($autoSaveActivity)
    {
        $this->autoSaveActivity = $autoSaveActivity;

        return $this;
    }

    /**
     * Get autoSaveActivity
     *
     * @return string
     */
    public function getAutoSaveActivity()
    {
        return $this->autoSaveActivity;
    }

    /**
     * Set widthOfHalf
     *
     * @param string $widthOfHalf
     *
     * @return setting
     */
    public function setWidthOfHalf($widthOfHalf)
    {
        $this->widthOfHalf = $widthOfHalf;

        return $this;
    }

    /**
     * Get widthOfHalf
     *
     * @return string
     */
    public function getWidthOfHalf()
    {
        return $this->widthOfHalf;
    }

 

    /**
     * Set themeImageWidth
     *
     * @param string $themeImageWidth
     *
     * @return setting
     */
    public function setThemeImageWidth($themeImageWidth)
    {
        $this->themeImageWidth = $themeImageWidth;

        return $this;
    }

    /**
     * Get themeImageWidth
     *
     * @return string
     */
    public function getThemeImageWidth()
    {
        return $this->themeImageWidth;
    }

    /**
     * Set exportExcel
     *
     * @param string $exportExcel
     *
     * @return setting
     */
    public function setExportExcel($exportExcel)
    {
        $this->exportExcel = $exportExcel;

        return $this;
    }

    /**
     * Get exportExcel
     *
     * @return string
     */
    public function getExportExcel()
    {
        return $this->exportExcel;
    }

    /**
     * Set itemsPagedLists
     *
     * @param string $itemsPagedLists
     *
     * @return setting
     */
    public function setItemsPagedLists($itemsPagedLists)
    {
        $this->itemsPagedLists = $itemsPagedLists;

        return $this;
    }

    /**
     * Get itemsPagedLists
     *
     * @return string
     */
    public function getItemsPagedLists()
    {
        return $this->itemsPagedLists;
    }

    /**
     * Set usersHelpDocument
     *
     * @param string $usersHelpDocument
     *
     * @return setting
     */
    public function setUsersHelpDocument($usersHelpDocument)
    {
        $this->usersHelpDocument = $usersHelpDocument;

        return $this;
    }

    /**
     * Get usersHelpDocument
     *
     * @return string
     */
    public function getUsersHelpDocument()
    {
        return $this->usersHelpDocument;
    }

    /**
     * Set adminHelpDocument
     *
     * @param string $adminHelpDocument
     *
     * @return setting
     */
    public function setAdminHelpDocument($adminHelpDocument)
    {
        $this->adminHelpDocument = $adminHelpDocument;

        return $this;
    }

    /**
     * Get adminHelpDocument
     *
     * @return string
     */
    public function getAdminHelpDocument()
    {
        return $this->adminHelpDocument;
    }

    /**
     * Set buttonsStyle
     *
     * @param string $buttonsStyle
     *
     * @return setting
     */
    public function setButtonsStyle($buttonsStyle)
    {
        $this->buttonsStyle = $buttonsStyle;

        return $this;
    }

    /**
     * Get buttonsStyle
     *
     * @return string
     */
    public function getButtonsStyle()
    {
        return $this->buttonsStyle;
    }

    /**
     * Set showRatio
     *
     * @param string $showRatio
     *
     * @return setting
     */
    public function setShowRatio($showRatio)
    {
        $this->showRatio = $showRatio;

        return $this;
    }

    /**
     * Get showRatio
     *
     * @return string
     */
    public function getShowRatio()
    {
        return $this->showRatio;
    }

    /**
     * Set currentYearBgcolor
     *
     * @param string $currentYearBgcolor
     *
     * @return setting
     */
    public function setCurrentYearBgcolor($currentYearBgcolor)
    {
        $this->currentYearBgcolor = $currentYearBgcolor;

        return $this;
    }

    /**
     * Get currentYearBgcolor
     *
     * @return string
     */
    public function getCurrentYearBgcolor()
    {
        return $this->currentYearBgcolor;
    }

    /**
     * Set previousYearBgcolor
     *
     * @param string $previousYearBgcolor
     *
     * @return setting
     */
    public function setPreviousYearBgcolor($previousYearBgcolor)
    {
        $this->previousYearBgcolor = $previousYearBgcolor;

        return $this;
    }

    /**
     * Get previousYearBgcolor
     *
     * @return string
     */
    public function getPreviousYearBgcolor()
    {
        return $this->previousYearBgcolor;
    }

    /**
     * Set selectedReportSelectorColor
     *
     * @param string $selectedReportSelectorColor
     *
     * @return setting
     */
    public function setSelectedReportSelectorColor($selectedReportSelectorColor)
    {
        $this->selectedReportSelectorColor = $selectedReportSelectorColor;

        return $this;
    }

    /**
     * Get selectedReportSelectorColor
     *
     * @return string
     */
    public function getSelectedReportSelectorColor()
    {
        return $this->selectedReportSelectorColor;
    }

    /**
     * Set notSelectedReportSelectorColor
     *
     * @param string $notSelectedReportSelectorColor
     *
     * @return setting
     */
    public function setNotSelectedReportSelectorColor($notSelectedReportSelectorColor)
    {
        $this->notSelectedReportSelectorColor = $notSelectedReportSelectorColor;

        return $this;
    }

    /**
     * Get notSelectedReportSelectorColor
     *
     * @return string
     */
    public function getNotSelectedReportSelectorColor()
    {
        return $this->notSelectedReportSelectorColor;
    }

    /**
     * Set genericActivityColor
     *
     * @param string $genericActivityColor
     *
     * @return setting
     */
    public function setGenericActivityColor($genericActivityColor)
    {
        $this->genericActivityColor = $genericActivityColor;

        return $this;
    }

    /**
     * Get genericActivityColor
     *
     * @return string
     */
    public function getGenericActivityColor()
    {
        return $this->genericActivityColor;
    }

    /**
     * Set currentYearOfertaColor
     *
     * @param string $currentYearOfertaColor
     *
     * @return setting
     */
    public function setCurrentYearOfertaColor($currentYearOfertaColor)
    {
        $this->currentYearOfertaColor = $currentYearOfertaColor;

        return $this;
    }

    /**
     * Get currentYearOfertaColor
     *
     * @return string
     */
    public function getCurrentYearOfertaColor()
    {
        return $this->currentYearOfertaColor;
    }

    /**
     * Set lastYearOfertaColor
     *
     * @param string $lastYearOfertaColor
     *
     * @return setting
     */
    public function setLastYearOfertaColor($lastYearOfertaColor)
    {
        $this->lastYearOfertaColor = $lastYearOfertaColor;

        return $this;
    }

    /**
     * Get lastYearOfertaColor
     *
     * @return string
     */
    public function getLastYearOfertaColor()
    {
        return $this->lastYearOfertaColor;
    }

    /**
     * Set currentYearTiendasColor
     *
     * @param string $currentYearTiendasColor
     *
     * @return setting
     */
    public function setCurrentYearTiendasColor($currentYearTiendasColor)
    {
        $this->currentYearTiendasColor = $currentYearTiendasColor;

        return $this;
    }

    /**
     * Get currentYearTiendasColor
     *
     * @return string
     */
    public function getCurrentYearTiendasColor()
    {
        return $this->currentYearTiendasColor;
    }

    /**
     * Set lastYearTiendasColor
     *
     * @param string $lastYearTiendasColor
     *
     * @return setting
     */
    public function setLastYearTiendasColor($lastYearTiendasColor)
    {
        $this->lastYearTiendasColor = $lastYearTiendasColor;

        return $this;
    }

    /**
     * Get lastYearTiendasColor
     *
     * @return string
     */
    public function getLastYearTiendasColor()
    {
        return $this->lastYearTiendasColor;
    }

    /**
     * Set currentYearAdicionalColor
     *
     * @param string $currentYearAdicionalColor
     *
     * @return setting
     */
    public function setCurrentYearAdicionalColor($currentYearAdicionalColor)
    {
        $this->currentYearAdicionalColor = $currentYearAdicionalColor;

        return $this;
    }

    /**
     * Get currentYearAdicionalColor
     *
     * @return string
     */
    public function getCurrentYearAdicionalColor()
    {
        return $this->currentYearAdicionalColor;
    }

    /**
     * Set lastYearAdicionalColor
     *
     * @param string $lastYearAdicionalColor
     *
     * @return setting
     */
    public function setLastYearAdicionalColor($lastYearAdicionalColor)
    {
        $this->lastYearAdicionalColor = $lastYearAdicionalColor;

        return $this;
    }

    /**
     * Get lastYearAdicionalColor
     *
     * @return string
     */
    public function getLastYearAdicionalColor()
    {
        return $this->lastYearAdicionalColor;
    }

    /**
     * Set currentYearFolletoColor
     *
     * @param string $currentYearFolletoColor
     *
     * @return setting
     */
    public function setCurrentYearFolletoColor($currentYearFolletoColor)
    {
        $this->currentYearFolletoColor = $currentYearFolletoColor;

        return $this;
    }

    /**
     * Get currentYearFolletoColor
     *
     * @return string
     */
    public function getCurrentYearFolletoColor()
    {
        return $this->currentYearFolletoColor;
    }

    /**
     * Set lastYearFolletoColor
     *
     * @param string $lastYearFolletoColor
     *
     * @return setting
     */
    public function setLastYearFolletoColor($lastYearFolletoColor)
    {
        $this->lastYearFolletoColor = $lastYearFolletoColor;

        return $this;
    }

    /**
     * Get lastYearFolletoColor
     *
     * @return string
     */
    public function getLastYearFolletoColor()
    {
        return $this->lastYearFolletoColor;
    }

    /**
     * Set currentYearKpiQualityColor
     *
     * @param string $currentYearKpiQualityColor
     *
     * @return setting
     */
    public function setCurrentYearKpiQualityColor($currentYearKpiQualityColor)
    {
        $this->currentYearKpiQualityColor = $currentYearKpiQualityColor;

        return $this;
    }

    /**
     * Get currentYearKpiQualityColor
     *
     * @return string
     */
    public function getCurrentYearKpiQualityColor()
    {
        return $this->currentYearKpiQualityColor;
    }

    /**
     * Set lastYearKpiQualityColor
     *
     * @param string $lastYearKpiQualityColor
     *
     * @return setting
     */
    public function setLastYearKpiQualityColor($lastYearKpiQualityColor)
    {
        $this->lastYearKpiQualityColor = $lastYearKpiQualityColor;

        return $this;
    }

    /**
     * Get lastYearKpiQualityColor
     *
     * @return string
     */
    public function getLastYearKpiQualityColor()
    {
        return $this->lastYearKpiQualityColor;
    }

    /**
     * Set currentYearNetRevenueColor
     *
     * @param string $currentYearNetRevenueColor
     *
     * @return setting
     */
    public function setCurrentYearNetRevenueColor($currentYearNetRevenueColor)
    {
        $this->currentYearNetRevenueColor = $currentYearNetRevenueColor;

        return $this;
    }

    /**
     * Get currentYearNetRevenueColor
     *
     * @return string
     */
    public function getCurrentYearNetRevenueColor()
    {
        return $this->currentYearNetRevenueColor;
    }

    /**
     * Set currentYearForecastColor
     *
     * @param string $currentYearForecastColor
     *
     * @return setting
     */
    public function setCurrentYearForecastColor($currentYearForecastColor)
    {
        $this->currentYearForecastColor = $currentYearForecastColor;

        return $this;
    }

    /**
     * Get currentYearForecastColor
     *
     * @return string
     */
    public function getCurrentYearForecastColor()
    {
        return $this->currentYearForecastColor;
    }

    /**
     * Set currentYearNrVsLyColor
     *
     * @param string $currentYearNrVsLyColor
     *
     * @return setting
     */
    public function setCurrentYearNrVsLyColor($currentYearNrVsLyColor)
    {
        $this->currentYearNrVsLyColor = $currentYearNrVsLyColor;

        return $this;
    }

    /**
     * Get currentYearNrVsLyColor
     *
     * @return string
     */
    public function getCurrentYearNrVsLyColor()
    {
        return $this->currentYearNrVsLyColor;
    }

    /**
     * Set lastYearNetRevenueColor
     *
     * @param string $lastYearNetRevenueColor
     *
     * @return setting
     */
    public function setLastYearNetRevenueColor($lastYearNetRevenueColor)
    {
        $this->lastYearNetRevenueColor = $lastYearNetRevenueColor;

        return $this;
    }

    /**
     * Get lastYearNetRevenueColor
     *
     * @return string
     */
    public function getLastYearNetRevenueColor()
    {
        return $this->lastYearNetRevenueColor;
    }

    /**
     * Set lastYearForecastColor
     *
     * @param string $lastYearForecastColor
     *
     * @return setting
     */
    public function setLastYearForecastColor($lastYearForecastColor)
    {
        $this->lastYearForecastColor = $lastYearForecastColor;

        return $this;
    }

    /**
     * Get lastYearForecastColor
     *
     * @return string
     */
    public function getLastYearForecastColor()
    {
        return $this->lastYearForecastColor;
    }

    /**
     * Set lastYearNrVsLyColor
     *
     * @param string $lastYearNrVsLyColor
     *
     * @return setting
     */
    public function setLastYearNrVsLyColor($lastYearNrVsLyColor)
    {
        $this->lastYearNrVsLyColor = $lastYearNrVsLyColor;

        return $this;
    }

    /**
     * Get lastYearNrVsLyColor
     *
     * @return string
     */
    public function getLastYearNrVsLyColor()
    {
        return $this->lastYearNrVsLyColor;
    }

    /**
     * Set currentYearThemeColor
     *
     * @param string $currentYearThemeColor
     *
     * @return setting
     */
    public function setCurrentYearThemeColor($currentYearThemeColor)
    {
        $this->currentYearThemeColor = $currentYearThemeColor;

        return $this;
    }

    /**
     * Get currentYearThemeColor
     *
     * @return string
     */
    public function getCurrentYearThemeColor()
    {
        return $this->currentYearThemeColor;
    }

    /**
     * Set lastYearThemeColor
     *
     * @param string $lastYearThemeColor
     *
     * @return setting
     */
    public function setLastYearThemeColor($lastYearThemeColor)
    {
        $this->lastYearThemeColor = $lastYearThemeColor;

        return $this;
    }

    /**
     * Get lastYearThemeColor
     *
     * @return string
     */
    public function getLastYearThemeColor()
    {
        return $this->lastYearThemeColor;
    }

    /**
     * Set planificadoForeground
     *
     * @param string $planificadoForeground
     *
     * @return setting
     */
    public function setPlanificadoForeground($planificadoForeground)
    {
        $this->planificadoForeground = $planificadoForeground;

        return $this;
    }

    /**
     * Get planificadoForeground
     *
     * @return string
     */
    public function getPlanificadoForeground()
    {
        return $this->planificadoForeground;
    }

    /**
     * Set cerradoForeground
     *
     * @param string $cerradoForeground
     *
     * @return setting
     */
    public function setCerradoForeground($cerradoForeground)
    {
        $this->cerradoForeground = $cerradoForeground;

        return $this;
    }

    /**
     * Get cerradoForeground
     *
     * @return string
     */
    public function getCerradoForeground()
    {
        return $this->cerradoForeground;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return setting
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set quality
     *
     * @param string $quality
     *
     * @return setting
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;

        return $this;
    }

    /**
     * Get quality
     *
     * @return string
     */
    public function getQuality()
    {
        return $this->quality;
    }
}
