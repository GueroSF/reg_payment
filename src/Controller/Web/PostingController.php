<?php

namespace App\Controller\Web;

use App\Entity\Account;
use App\Entity\Category;
use App\Entity\Posting;
use App\Form\PostingFormType;
use App\Service\PreparePostingData;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            [
                'accounts' => $service->getAllAccounts(),
                'credit'   => $service->getSumOnCreditCategory(),
                'backUrl'  => null,
            ]
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
            [
                'categories' => $service->getAllCategoriesForAccount($account),
                'backUrl'    => $this->generateUrl('web_trans_accounts'),
            ]
        );
    }

    /**
     * @Route("/account/{accountId}/category/{categoryId}", name="postings", methods={"GET"})
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
            PostingFormType::class,
            [
                'account'  => $account,
                'category' => $category,
            ],
            [
                'action' => $this->generateUrl('web_trans_create_posting'),
            ]
        );

        $postings = $this->getDoctrine()->getRepository(Posting::class)
            ->findByAccountAndCategory($account, $category);

        return $this->render(
            'posting/posting.html.twig',
            [
                'form'     => $form->createView(),
                'postings' => $postings,
                'category' => $service->getCategory($account, $category),
                'backUrl'  => $this->generateUrl('web_trans_account', ['id' => $account->getId()]),
            ]
        );
    }

    /**
     * @Route("/posting-create", methods={"POST"}, name="create_posting")
     */
    public function createNewPosting(Request $request): Response
    {
        $form = $this->createForm(
            PostingFormType::class,
            null,
            ['data_class' => Posting::class]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Posting $posting */
            $posting = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($posting);
            $em->flush();

            $account = $posting->getAccount();
            $category = $posting->getCategory();
        }

        return $this->redirectToRoute(
            'web_trans_postings',
            [
                'accountId'  => $account->getId(),
                'categoryId' => $category->getId(),
            ]
        );
    }

    /**
     * @Route("/account/{accountId}/category/{categoryId}/delete", name="delete", methods={"GET"})
     * @ParamConverter("account", options={"id"="accountId"})
     * @ParamConverter("category", options={"id"="categoryId"})
     */
    public function removeCategory(PreparePostingData $service, Account $account, Category $category): Response
    {
        $result = $service->removePostingFor($account, $category);

        return $this->redirectToRoute(
            'web_trans_account',
            [
                'id' => $account->getId(),
            ]
        );
    }
}
