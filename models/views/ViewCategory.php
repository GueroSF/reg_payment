<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 15.08.17
 * Time: 10:34
 */

namespace model\views;


use model\Category;

class ViewCategory extends Category
{
   use Layout;

    public $title = 'Категории';

    public function render($view = 'category')
    {
        $this->fileCSS = 'category.css';
        $this->fileJS = 'category.js';
        include_once $this->header;
        if ($view == 'payments') {
            include_once '../views/payment_list.html.php';
        } else {
            include_once '../views/category_page.html.php';
        }
        include_once $this->footer;
    }
}