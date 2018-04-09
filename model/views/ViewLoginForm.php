<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 03.08.17
 * Time: 18:07
 */

namespace model\views;


class ViewLoginForm
{
	public $title = 'Вход';

    public function render()
	{
		include_once '../views/login.html.php';
	}
}