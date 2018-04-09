<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 14.08.17
 * Time: 17:19
 */

namespace model;


class NameMonth
{
    public static function get($value)
    {
        $month = ['1'=>'Январь','Февраль','Март','Апрель', 'Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'];
        $num = explode('_', $value);
        return $month[$num[0]];
    }
}