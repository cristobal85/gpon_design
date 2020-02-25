<?php

namespace App\Controller;

use App\Entity\PatchPanel;
use App\Form\PatchPanelType;
use App\Repository\PatchPanelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/patch-panel")
 */
class PatchPanelController extends AbstractController
{
    /**
     * @Route("/", name="patch_panel_index", methods={"GET"})
     */
    public function index(PatchPanelRepository $patchPanelRepository): Response
    {
        return $this->render('patch_panel/index.html.twig', [
            'patch_panels' => $patchPanelRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="patch_panel_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $patchPanel = new PatchPanel();
        $form = $this->createForm(PatchPanelType::class, $patchPanel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            \App\EntityPattern\PatternGeneratorFactory::make($entityManager, $patchPanel)->generate();
            $entityManager->persist($patchPanel);
            $entityManager->flush();

            return $this->redirectToRoute('patch_panel_index');
        }

        return $this->render('patch_panel/new.html.twig', [
            'patch_panel' => $patchPanel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="patch_panel_show", methods={"GET"})
     */
    public function show(PatchPanel $patchPanel): Response
    {
        return $this->render('patch_panel/show.html.twig', [
            'patch_panel' => $patchPanel,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="patch_panel_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, PatchPanel $patchPanel): Response
    {
        $form = $this->createForm(PatchPanelType::class, $patchPanel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('patch_panel_index', [
                'id' => $patchPanel->getId(),
            ]);
        }

        return $this->render('patch_panel/edit.html.twig', [
            'patch_panel' => $patchPanel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="patch_panel_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, PatchPanel $patchPanel): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patchPanel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($patchPanel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('patch_panel_index');
    }
}
