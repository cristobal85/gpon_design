<?php

namespace App\Controller;

use App\Entity\PatchPanelSlot;
use App\Form\PatchPanelSlotType;
use App\Repository\PatchPanelSlotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Serializer\CircularSerializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/patch-panel-slot")
 */
class PatchPanelSlotController extends AbstractController
{
    /**
     * @Route("/", name="patch_panel_slot_index", methods={"GET"})
     */
    public function index(PatchPanelSlotRepository $patchPanelSlotRepository): Response
    {
        return $this->render('patch_panel_slot/index.html.twig', [
            'patch_panel_slots' => $patchPanelSlotRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="patch_panel_slot_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $patchPanelSlot = new PatchPanelSlot();
        $form = $this->createForm(PatchPanelSlotType::class, $patchPanelSlot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patchPanelSlot);
            $entityManager->flush();

            return $this->redirectToRoute('patch_panel_slot_index');
        }

        return $this->render('patch_panel_slot/new.html.twig', [
            'patch_panel_slot' => $patchPanelSlot,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="patch_panel_slot_show", methods={"GET"})
     */
    public function show(
            PatchPanelSlot $patchPanelSlot,
            Request $request,
            CircularSerializer $serializer): Response
    {
        if ($request->isXmlHttpRequest()) {
            $jsonObject = $serializer->serialize($patchPanelSlot, ['patch-panel']);

            return new Response($jsonObject);
        }
        
        return $this->render('patch_panel_slot/show.html.twig', [
            'patch_panel_slot' => $patchPanelSlot,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="patch_panel_slot_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, PatchPanelSlot $patchPanelSlot): Response
    {
        $form = $this->createForm(PatchPanelSlotType::class, $patchPanelSlot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('patch_panel_slot_index', [
                'id' => $patchPanelSlot->getId(),
            ]);
        }

        return $this->render('patch_panel_slot/edit.html.twig', [
            'patch_panel_slot' => $patchPanelSlot,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="patch_panel_slot_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, PatchPanelSlot $patchPanelSlot): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patchPanelSlot->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($patchPanelSlot);
            $entityManager->flush();
        }

        return $this->redirectToRoute('patch_panel_slot_index');
    }
}
