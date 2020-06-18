<?php

namespace App\Controller\Web;

use App\Entity\Account;
use App\Entity\Category;
use App\Entity\Posting;
use App\Form\CategoryFormType;
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
        $categoriesNotNullSum = [];
        $categoriesWithNull = [];

        foreach ($service->getAllCategoriesForAccount($account) as $categoryDTO) {
            if ($categoryDTO->getSum() === 0.0) {
                $categoriesWithNull[] = $categoryDTO;
            } else {
                $categoriesNotNullSum[] = $categoryDTO;
            }
        }

        return $this->render(
            'posting/categories.html.twig',
            [
                'categoriesNotNullSum' => $categoriesNotNullSum,
                'categoriesWithNull'   => $categoriesWithNull,
                'backUrl'              => $this->generateUrl('web_trans_accounts'),
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
    public function postings(PreparePostingData $service, Account $account, Category $category): Response
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

        $limit = 10;
        $postings = $this->limitPosting($account, $category, $limit, 0);
        $amount = count($postings);

        return $this->render(
            'posting/posting.html.twig',
            [
                'form'     => $form->createView(),
                'loadUrl'  => $this->generateUrl(
                    'web_trans_postings_ajax',
                    [
                        'accountId'  => $account->getId(),
                        'categoryId' => $category->getId(),
                    ]
                ),
                'limit'    => $limit,
                'amount'   => $amount,
                'postings' => $postings,
                'category' => $service->getCategory($account, $category),
                'backUrl'  => $this->generateUrl('web_trans_account', ['id' => $account->getId()]),
            ]
        );
    }

    /**
     * @Route("/account/{accountId}/category/{categoryId}", name="postings_ajax", methods={"POST"})
     * @ParamConverter("account", options={"id"="accountId"})
     * @ParamConverter("category", options={"id"="categoryId"})
     */
    public function ajaxPostings(Request $request, Account $account, Category $category): Response
    {
        $body = json_decode($request->getContent(), true);

        $postings = $this->limitPosting($account, $category, $body['limit'], $body['offset']);

        return $this->json([
            'amount' => count($postings),
            'html'   => $this->renderView('posting/_posting-list.html.twig', ['postings' => $postings])
        ]);
    }

    private function limitPosting(Account $account, Category $category, ?int $limit = null, ?int $offset = null): array
    {
        return $this->getDoctrine()->getRepository(Posting::class)
            ->findByAccountAndCategory($account, $category, $limit, $offset);
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

    /**
     * @Route("/create-category", name="create_category", methods={"GET", "POST"})
     */
    public function createCategory(Request $request): Response
    {
        $form = $this->createForm(CategoryFormType::class);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $category = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();

                $account = $form->get('account')->getData();

                return $this->redirectToRoute(
                    'web_trans_postings',
                    [
                        'accountId'  => $account->getId(),
                        'categoryId' => $category->getId(),
                    ]
                );
            }
        }

        return $this->render(
            '/posting/create-category.html.twig',
            [
                'form'    => $form->createView(),
                'backUrl' => $this->generateUrl('web_trans_accounts'),
            ]
        );
    }
}
