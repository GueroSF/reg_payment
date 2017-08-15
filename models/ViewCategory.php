<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 15.08.17
 * Time: 10:34
 */

namespace model;


class ViewCategory extends Category implements HeaderPages
{
    public $title = 'Категории';

    public function render($view = 'category')
    {
        include_once self::HEAD;
        if ($view == 'payments') {
            include_once '../views/payment_list.html.php';
        } else {
            include_once '../views/category_page.html.php';
        }
    }
}