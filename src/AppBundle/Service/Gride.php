<?php

namespace AppBundle\Service;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use Doctrine\Bundle\DoctrineBundle\Registry;
class Gride
{

    private $mode;  //0 one client 1 one brand
    private $view;  //0     client 1     brand
    private $rows;  //mode=0 rows of brands, mode=1 rows of clients 
    private $start_month;
    private $number_month;
    private $year;
    private $show_last_year;
    private $titles;
    
    
    public function __construct($mode)
    {
        $this->mode=$mode;
    }
    //getData()
    //get view mode
    //get rows
    //get monthes
    //get years
    //get subbrands
    //get translated titiles




}