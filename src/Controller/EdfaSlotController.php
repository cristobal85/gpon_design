<?php

namespace App\Controller;

use App\Entity\EdfaSlot;
use App\Form\EdfaSlotType;
use App\Repository\EdfaSlotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/edfa-slot")
 */
class EdfaSlotController extends AbstractController
{
    /**
     * @Route("/", name="edfa_slot_index", methods={"GET"})
     */
    public function index(EdfaSlotRepository $edfaSlotRepository): Response
    {
        return $this->render('edfa_slot/index.html.twig', [
            'edfa_slots' => $edfaSlotRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="edfa_slot_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $edfaSlot = new EdfaSlot();
        $form = $this->createForm(EdfaSlotType::class, $edfaSlot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($edfaSlot);
            $entityManager->flush();

            return $this->redirectToRoute('edfa_slot_index');
        }

        return $this->render('edfa_slot/new.html.twig', [
            'edfa_slot' => $edfaSlot,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="edfa_slot_show", methods={"GET"})
     */
    public function show(EdfaSlot $edfaSlot): Response
    {
        return $this->render('edfa_slot/show.html.twig', [
            'edfa_slot' => $edfaSlot,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edfa_slot_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, EdfaSlot $edfaSlot): Response
    {
        $form = $this->createForm(EdfaSlotType::class, $edfaSlot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('edfa_slot_index', [
                'id' => $edfaSlot->getId(),
            ]);
        }

        return $this->render('edfa_slot/edit.html.twig', [
            'edfa_slot' => $edfaSlot,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="edfa_slot_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, EdfaSlot $edfaSlot): Response
    {
        if ($this->isCsrfTokenValid('delete'.$edfaSlot->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($edfaSlot);
            $entityManager->flush();
        }

        return $this->redirectToRoute('edfa_slot_index');
    }
}
