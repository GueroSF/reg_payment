<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 19.01.2020
 */

namespace App\Controller\Web;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(name="web_list_account")
 */
class AccountController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('test');
    }
}
