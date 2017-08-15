<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 15.08.17
 * Time: 9:53
 */

namespace model;


class ViewProductOil extends ProductOil implements HeaderPages
{
    public $title = 'Продукты/бензин';


    public function render()
    {
        $aMoneyMonth = $this->getSum();
        include_once self::HEAD;
        include_once '../views/product_oil.html.php';
    }
}