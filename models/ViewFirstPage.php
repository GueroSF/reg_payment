<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 03.08.17
 * Time: 16:50
 */

namespace view;


use model\Account;

class ViewFirstPage extends Account
{
	public $title = 'Главная';

	public function render()
	{

		include_once '../views/head_page.html.php';
		include_once '../views/account_page.html.php';
//		var_dump($this->getSumAllAccount());
	}
}