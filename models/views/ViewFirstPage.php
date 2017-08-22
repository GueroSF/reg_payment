<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 03.08.17
 * Time: 16:50
 */

namespace model\views;


use model\Account;

class ViewFirstPage extends Account
{
	use Layout;

    public $title = 'Главная';

	public $content = '../views/account_page.html.php';

}