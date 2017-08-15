<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 15.08.17
 * Time: 9:53
 */

namespace model;


class ViewProductOil extends ProductOil
{
    public $title = 'Продукты/бензин';


    public function render()
    {
        $aMoneyMonth = $this->getSum();
//        $aMoneyMonth = array_merge($this->getPayment(),$this->getSum());
        include_once '../views/head_page.html.php';
        include_once '../views/product_oil.html.php';
//	    echo 'Product oil';
    }
}