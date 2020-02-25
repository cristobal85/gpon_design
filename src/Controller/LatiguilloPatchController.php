<?php

namespace App\Controller;

use App\Entity\LatiguilloPatch;
use App\Form\LatiguilloPatchType;
use App\Repository\LatiguilloPatchRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/latiguillo-patch")
 */
class LatiguilloPatchController extends AbstractController
{
    /**
     * @Route("/", name="latiguillo_patch_index", methods={"GET"})
     */
    public function index(LatiguilloPatchRepository $latiguilloPatchRepository): Response
    {
        return $this->render('latiguillo_patch/index.html.twig', [
            'latiguillo_patches' => $latiguilloPatchRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="latiguillo_patch_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $latiguilloPatch = new LatiguilloPatch();
        $form = $this->createForm(LatiguilloPatchType::class, $latiguilloPatch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            try {
                $entityManager->persist($latiguilloPatch);
                $entityManager->flush();
            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                $this->addFlash('error', 'Ya se ha usado el puerto del PATCH PANNEL o EDFA en otro latiguillo.');
            } 

            return $this->redirectToRoute('latiguillo_patch_index');
        }

        return $this->render('latiguillo_patch/new.html.twig', [
            'latiguillo_patch' => $latiguilloPatch,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="latiguillo_patch_show", methods={"GET"})
     */
    public function show(LatiguilloPatch $latiguilloPatch): Response
    {
        return $this->render('latiguillo_patch/show.html.twig', [
            'latiguillo_patch' => $latiguilloPatch,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="latiguillo_patch_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, LatiguilloPatch $latiguilloPatch): Response
    {
        $form = $this->createForm(LatiguilloPatchType::class, $latiguilloPatch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                $this->addFlash('error', 'Ya se ha usado el puerto del PATCH PANEL o EDFA en otro latiguillo.');
            }

            return $this->redirectToRoute('latiguillo_patch_index', [
                'id' => $latiguilloPatch->getId(),
            ]);
        }

        return $this->render('latiguillo_patch/edit.html.twig', [
            'latiguillo_patch' => $latiguilloPatch,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="latiguillo_patch_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, LatiguilloPatch $latiguilloPatch): Response
    {
        if ($this->isCsrfTokenValid('delete'.$latiguilloPatch->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($latiguilloPatch);
            $entityManager->flush();
        }

        return $this->redirectToRoute('latiguillo_patch_index');
    }
}
