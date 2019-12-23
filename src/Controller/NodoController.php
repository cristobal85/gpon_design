<?php

namespace App\Controller;

use App\Entity\Nodo;
use App\Form\NodoType;
use App\Repository\NodoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/nodo")
 */
class NodoController extends AbstractController
{
    /**
     * @Route("/", name="nodo_index", methods={"GET"})
     */
    public function index(NodoRepository $nodoRepository): Response
    {
        return $this->render('nodo/index.html.twig', [
            'nodos' => $nodoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="nodo_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $nodo = new Nodo();
        $form = $this->createForm(NodoType::class, $nodo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            \App\EntityPattern\PatternGeneratorFactory::make($entityManager, $nodo)->generate();
            $entityManager->persist($nodo);
            $entityManager->flush();

            return $this->redirectToRoute('nodo_index');
        }

        return $this->render('nodo/new.html.twig', [
            'nodo' => $nodo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="nodo_show", methods={"GET"})
     */
    public function show(Nodo $nodo): Response
    {
        return $this->render('nodo/show.html.twig', [
            'nodo' => $nodo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="nodo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Nodo $nodo): Response
    {
        $form = $this->createForm(NodoType::class, $nodo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('nodo_index', [
                'id' => $nodo->getId(),
            ]);
        }

        return $this->render('nodo/edit.html.twig', [
            'nodo' => $nodo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="nodo_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Nodo $nodo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nodo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($nodo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('nodo_index');
    }
}
