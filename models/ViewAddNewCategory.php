<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 17.08.17
 * Time: 11:30
 */

namespace model;


class ViewAddNewCategory implements HeaderPages
{
    public $title = 'Добавление новой категории';

    public function render()
    {
        include_once self::HEAD;
        include_once '../views/add_category.html.php';
    }
}