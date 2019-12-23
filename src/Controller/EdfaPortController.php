<?php

namespace App\Controller;

use App\Entity\EdfaPort;
use App\Form\EdfaPortType;
use App\Repository\EdfaPortRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/edfa-port")
 */
class EdfaPortController extends AbstractController
{
    /**
     * @Route("/", name="edfa_port_index", methods={"GET"})
     */
    public function index(EdfaPortRepository $edfaPortRepository): Response
    {
        return $this->render('edfa_port/index.html.twig', [
            'edfa_ports' => $edfaPortRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="edfa_port_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $edfaPort = new EdfaPort();
        $form = $this->createForm(EdfaPortType::class, $edfaPort);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($edfaPort);
            $entityManager->flush();

            return $this->redirectToRoute('edfa_port_index');
        }

        return $this->render('edfa_port/new.html.twig', [
            'edfa_port' => $edfaPort,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="edfa_port_show", methods={"GET"})
     */
    public function show(EdfaPort $edfaPort): Response
    {
        return $this->render('edfa_port/show.html.twig', [
            'edfa_port' => $edfaPort,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edfa_port_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EdfaPort $edfaPort): Response
    {
        $form = $this->createForm(EdfaPortType::class, $edfaPort);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('edfa_port_index', [
                'id' => $edfaPort->getId(),
            ]);
        }

        return $this->render('edfa_port/edit.html.twig', [
            'edfa_port' => $edfaPort,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="edfa_port_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EdfaPort $edfaPort): Response
    {
        if ($this->isCsrfTokenValid('delete'.$edfaPort->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($edfaPort);
            $entityManager->flush();
        }

        return $this->redirectToRoute('edfa_port_index');
    }
}
