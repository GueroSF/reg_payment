<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 03.08.17
 * Time: 16:50
 */

namespace model;


use model\Account;

class ViewFirstPage extends Account implements HeaderPages
{
	public $title = 'Главная';

	public function render()
	{

		include_once self::HEAD;
		include_once '../views/account_page.html.php';
//		var_dump($this->getSumAllAccount());
	}
}