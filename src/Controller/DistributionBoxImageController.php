<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\DistributionBox;
use App\Form\DistributionBoxUploadImageType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DistributionBoxImageController extends AbstractController
{
    
    /**
     * @Route("/distribution-box-image/{id}/upload", name="distribution_box_image_upload", methods={"GET","POST"})
     */
    public function upload(Request $request, DistributionBox $distributionBox): Response {
        $form = $this->createForm(DistributionBoxUploadImageType::class, $distributionBox);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Fotos modificadas correctamente.');
        }

        return $this->render('distribution_box_image/upload.html.twig', [
            'distribution_box' => $distributionBox,
            'form' => $form->createView(),
        ]);
    }
}
