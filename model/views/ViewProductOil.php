<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 15.08.17
 * Time: 9:53
 */

namespace model\views;


use model\ProductOil;

class ViewProductOil extends ProductOil
{
    use Layout;

    public $title = 'Продукты/бензин';

    public $content = '../views/product_oil.html.php';

}