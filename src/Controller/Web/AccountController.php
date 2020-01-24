<?php
declare(strict_types=1);

namespace App\Controller\Web;


use App\Entity\Account;
use App\Entity\Transaction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="web_list_account_")
 */
class AccountController extends AbstractController
{

    /**
     * @Route("/account", name="index")
     *
     * @return Response
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Account::class);

        $accounts = $repo->findAll();

        $repo2 = $this->getDoctrine()->getRepository(Transaction::class);

        $tr = $repo2->find(1);

        $name = $tr->getCategory()->getName();

        return $this->render('account/index.html.twig');
    }
}
