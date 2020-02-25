<?php

namespace App\Controller;

use App\Entity\Olt;
use App\Form\OltType;
use App\Repository\OltRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/olt")
 */
class OltController extends AbstractController
{
    /**
     * @Route("/", name="olt_index", methods={"GET"})
     */
    public function index(OltRepository $oltRepository): Response
    {
        return $this->render('olt/index.html.twig', [
            'olts' => $oltRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="olt_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $olt = new Olt();
        $form = $this->createForm(OltType::class, $olt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($olt);
            $entityManager->flush();

            return $this->redirectToRoute('olt_index');
        }

        return $this->render('olt/new.html.twig', [
            'olt' => $olt,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="olt_show", methods={"GET"})
     */
    public function show(Olt $olt): Response
    {
        return $this->render('olt/show.html.twig', [
            'olt' => $olt,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="olt_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Olt $olt): Response
    {
        $form = $this->createForm(OltType::class, $olt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('olt_index', [
                'id' => $olt->getId(),
            ]);
        }

        return $this->render('olt/edit.html.twig', [
            'olt' => $olt,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="olt_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Olt $olt): Response
    {
        if ($this->isCsrfTokenValid('delete'.$olt->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($olt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('olt_index');
    }
}
