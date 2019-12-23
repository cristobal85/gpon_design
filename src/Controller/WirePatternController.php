<?php

namespace App\Controller;

use App\Entity\WirePattern;
use App\Form\WirePatternType;
use App\Repository\WirePatternRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wire-pattern")
 */
class WirePatternController extends AbstractController
{
    /**
     * @Route("/", name="wire_pattern_index", methods={"GET"})
     */
    public function index(WirePatternRepository $wirePatternRepository): Response
    {
        return $this->render('wire_pattern/index.html.twig', [
            'wire_patterns' => $wirePatternRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="wire_pattern_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $wirePattern = new WirePattern();
        $form = $this->createForm(WirePatternType::class, $wirePattern);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($wirePattern);
            $entityManager->flush();

            return $this->redirectToRoute('wire_pattern_index');
        }

        return $this->render('wire_pattern/new.html.twig', [
            'wire_pattern' => $wirePattern,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="wire_pattern_show", methods={"GET"})
     */
    public function show(WirePattern $wirePattern): Response
    {
        return $this->render('wire_pattern/show.html.twig', [
            'wire_pattern' => $wirePattern,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="wire_pattern_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, WirePattern $wirePattern): Response
    {
        $form = $this->createForm(WirePatternType::class, $wirePattern);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('wire_pattern_index');
        }

        return $this->render('wire_pattern/edit.html.twig', [
            'wire_pattern' => $wirePattern,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="wire_pattern_delete", methods={"DELETE"})
     */
    public function delete(Request $request, WirePattern $wirePattern): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wirePattern->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($wirePattern);
            $entityManager->flush();
        }

        return $this->redirectToRoute('wire_pattern_index');
    }
}
