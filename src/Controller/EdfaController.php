<?php

namespace App\Controller;

use App\Entity\Edfa;
use App\Form\EdfaType;
use App\Repository\EdfaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/edfa")
 */
class EdfaController extends AbstractController
{
    /**
     * @Route("/", name="edfa_index", methods={"GET"})
     */
    public function index(EdfaRepository $edfaRepository): Response
    {
        return $this->render('edfa/index.html.twig', [
            'edfas' => $edfaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="edfa_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $edfa = new Edfa();
        $form = $this->createForm(EdfaType::class, $edfa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            \App\EntityPattern\PatternGeneratorFactory::make($entityManager, $edfa)->generate();
            $entityManager->persist($edfa);
            $entityManager->flush();

            return $this->redirectToRoute('edfa_index');
        }

        return $this->render('edfa/new.html.twig', [
            'edfa' => $edfa,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="edfa_show", methods={"GET"})
     */
    public function show(Edfa $edfa): Response
    {
        return $this->render('edfa/show.html.twig', [
            'edfa' => $edfa,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edfa_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Edfa $edfa): Response
    {
        $form = $this->createForm(EdfaType::class, $edfa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('edfa_index', [
                'id' => $edfa->getId(),
            ]);
        }

        return $this->render('edfa/edit.html.twig', [
            'edfa' => $edfa,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="edfa_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Edfa $edfa): Response
    {
        if ($this->isCsrfTokenValid('delete'.$edfa->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($edfa);
            $entityManager->flush();
        }

        return $this->redirectToRoute('edfa_index');
    }
}
