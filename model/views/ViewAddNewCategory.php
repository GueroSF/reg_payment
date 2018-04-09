<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 17.08.17
 * Time: 11:30
 */

namespace model\views;


use model\views\Layout;

class ViewAddNewCategory
{
    use Layout;

    public $title = 'Добавление новой категории';

    public $content = '../views/add_category.html.php';

}