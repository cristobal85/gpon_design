<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\SubscriberBox;
use App\Form\SubscriberBoxUploadImageType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriberBoxImageController extends AbstractController {

    /**
     * @Route("/subscriber-box-image/{id}/upload", name="subscriber_box_image_upload", methods={"GET","POST"})
     */
    public function upload(Request $request, SubscriberBox $subscriberBox): Response {
        $form = $this->createForm(SubscriberBoxUploadImageType::class, $subscriberBox);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Fotos modificadas correctamente.');
        }

        return $this->render('subscriber_box_image/upload.html.twig', [
            'subscriber_box' => $subscriberBox,
            'form' => $form->createView(),
        ]);
    }

}
