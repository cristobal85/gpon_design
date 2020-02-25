<?php

namespace App\Controller;

use App\Entity\OltSlot;
use App\Form\OltSlotType;
use App\Repository\OltSlotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/olt-slot")
 */
class OltSlotController extends AbstractController
{
    /**
     * @Route("/", name="olt_slot_index", methods={"GET"})
     */
    public function index(OltSlotRepository $oltSlotRepository): Response
    {
        return $this->render('olt_slot/index.html.twig', [
            'olt_slots' => $oltSlotRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="olt_slot_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $oltSlot = new OltSlot();
        $form = $this->createForm(OltSlotType::class, $oltSlot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            \App\EntityPattern\PatternGeneratorFactory::make($entityManager, $oltSlot)->generate();
            $entityManager->persist($oltSlot);
            $entityManager->flush();

            return $this->redirectToRoute('olt_slot_index');
        }

        return $this->render('olt_slot/new.html.twig', [
            'olt_slot' => $oltSlot,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="olt_slot_show", methods={"GET"})
     */
    public function show(OltSlot $oltSlot): Response
    {
        return $this->render('olt_slot/show.html.twig', [
            'olt_slot' => $oltSlot,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="olt_slot_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, OltSlot $oltSlot): Response
    {
        $form = $this->createForm(OltSlotType::class, $oltSlot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('olt_slot_index', [
                'id' => $oltSlot->getId(),
            ]);
        }

        return $this->render('olt_slot/edit.html.twig', [
            'olt_slot' => $oltSlot,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="olt_slot_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, OltSlot $oltSlot): Response
    {
        if ($this->isCsrfTokenValid('delete'.$oltSlot->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($oltSlot);
            $entityManager->flush();
        }

        return $this->redirectToRoute('olt_slot_index');
    }
}
