<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 16.08.17
 * Time: 16:12
 */

namespace model;


use Doctrine\ORM\EntityManager;
use model\views\ViewAddNewCategory;
use model\views\ViewCategory;
use model\views\ViewFirstPage;
use model\views\ViewProductOil;
use Psr\Http\Message\ServerRequestInterface;

class Url
{
    private $entityManager;
    private $request;

    public function __construct(EntityManager $entityManager, ServerRequestInterface $request)
    {
        $this->entityManager = $entityManager;
        $this->request = $request;
    }

    public static $btmBack = '.';

    public static function homeUrl()
    {
        $protocol = 'https://';

        if (defined('APP_DEV')) {
            $protocol = 'http://';
        }

        return $protocol . $_SERVER['HTTP_HOST'];
    }

    public function manager()
    {
        $url = $this->request->getUri()->getPath();
        $body = $this->request->getParsedBody();

        if (isset($body['action']) && $body['action'] === 'addCategory') {
            Category::addNewCategory($body);
        }
        $rawUrl = explode('/', $url);
//        if (count($rawUrl)>5) header("Location: ".self::homeUrl());
        switch ($rawUrl[1]) {
            case ('product_oil'):
                $oViewProductOil = new ViewProductOil();
                if (isset($body['action']) && $body['action'] === 'addPayment') {
                    if (!$oViewProductOil->addPayment()) {
                        echo 'Какае-то ошибка';
                    }
                }
                $oViewProductOil->render();
                break;
            case ('account'):
                if (empty($rawUrl[2])) {
                    header("Location: " . self::homeUrl());
                }
                $oCategory = new ViewCategory($rawUrl[2]);
                if (isset($rawUrl[3]) && $rawUrl[3] === 'category') {
                    if (empty($rawUrl[4])) {
                        header("Location: " . self::getNewUrl($rawUrl, 3));
                    }
                    $oCategory->iCategoryId = $rawUrl[4];
                    if (isset($body['action']) && $body['action'] === 'addPayment') {
                        if (!$oCategory->addPayment()) {
                            echo 'Какае-то ошибка';
                        }
                    }
                    self::$btmBack = self::getNewUrl($rawUrl, 3);
                    $oCategory->render('payments');
                    break;
                } /*elseif (is_numeric($rawUrl[3])) {
                    header("Location: ".self::homeUrl());
                }*/
                /** TODO добавить обработку не правильных адресов */
                self::$btmBack = '..';
                $oCategory->render();
                break;
            case ('category_add'):
                (new ViewAddNewCategory())->render();
                break;
            default:
                (new ViewFirstPage())->render();
                break;
        }
    }

    public static function getNewUrl(array $aUrl, int $key)
    {
        array_splice($aUrl, $key);

        return rtrim(implode('/', $aUrl), '/');
    }
}