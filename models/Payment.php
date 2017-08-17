<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 15.08.17
 * Time: 10:18
 */

namespace model;


class Payment
{
    use ConnectDB;
    use ErrorOutput;

    /**
     * Возвращает возможные операции (приход, расход)
     *
     * @return array|bool
     */
    public static function getOperations()
    {
        try {
            $s = self::getConnect()->query('SELECT * FROM `buh_operation`');
        } catch (\PDOException $e) {
            self::send($e,false);
            return false;
//            errorMessage('Ошибка получения вида операций');
        }
        return $s->fetchALL();
    }
}