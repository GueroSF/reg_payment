<?php
declare(strict_types=1);

namespace App\Controller\Web;


use App\Entity\ToastMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/toast", name="toast_")
 */
class ToastMessageController extends AbstractController
{
    /**
     * @Route("/mark-as-read/{id}", name="mark_as_read", methods={"POST"})
     */
    public function markAsRead(ToastMessage $message): Response
    {
        $message->setReadAt(new \DateTime('now'));

        $dm = $this->getDoctrine()->getManager();
        $dm->persist($message);
        $dm->flush();

        return $this->json('ok');
    }
}
