<?php

namespace App\Controller\Web;

use App\Entity\Account;
use App\Entity\Category;
use App\Entity\Posting;
use App\Form\PostingType;
use App\Service\PreparePostingData;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/posting", name="web_trans_")
 */
class PostingController extends AbstractController
{
    /**
     * @Route("/accounts", name="accounts")
     * @param PreparePostingData $service
     * @return Response
     */
    public function accounts(PreparePostingData $service): Response
    {
        return $this->render(
            'posting/accounts.html.twig',
            ['accounts' => $service->getAllAccounts()]
        );
    }

    /**
     * @Route("/account/{id}", name="account")
     *
     * @param PreparePostingData $service
     * @param Account $account
     * @return Response
     */
    public function account(PreparePostingData $service, Account $account): Response
    {
        return $this->render(
            'posting/categories.html.twig',
            ['categories' => $service->getAllCategoriesForAccount($account)]
        );
    }

    /**
     * @Route("/account/{accountId}/category/{categoryId}", name="postings")
     * @ParamConverter("account", options={"id"="accountId"})
     * @ParamConverter("category", options={"id"="categoryId"})
     *
     * @param Account $account
     * @param Category $category
     * @return Response
     */
    public function allPostings(PreparePostingData $service, Account $account, Category $category): Response
    {
        $form = $this->createForm(
            PostingType::class,
            [
                'account' => $account,
                'category' => $category
            ]
        );

        $postings = $this->getDoctrine()->getRepository(Posting::class)
            ->findByAccountAndCategory($account, $category);

        return $this->render(
            'posting/posting.html.twig',
            [
                'form'     => $form->createView(),
                'postings' => $postings,
                'category' => $service->getCategory($account, $category)
            ]
        );
    }
}
