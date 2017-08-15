<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 03.08.17
 * Time: 14:33
 */

namespace model;


trait ErrorOutput
{
	public function send($e,$email=true){
		if ($email){
			if(!mail('guerosf@yandex.ru','Error',$e->getMessage())){
				echo 'беда! Письмо не отправленно';
			}
		} else{
			echo '<pre>';
			var_dump($e->getMessage());
			echo '</pre>';
		}
	}
}