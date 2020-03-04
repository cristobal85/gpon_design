<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Torpedo;
use App\Form\TorpedoUploadImageType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TorpedoImageController extends AbstractController
{
    
    /**
     * @Route("/torpedo-image/{id}/upload", name="torpedo_image_upload", methods={"GET","POST"})
     */
    public function upload(Request $request, Torpedo $torpedo): Response {
        $form = $this->createForm(TorpedoUploadImageType::class, $torpedo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Fotos modificadas correctamente.');
        }

        return $this->render('torpedo_image/upload.html.twig', [
            'torpedo' => $torpedo,
            'form' => $form->createView(),
        ]);
    }
}
