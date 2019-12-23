<?php

namespace App\Controller;

use App\Entity\OltPort;
use App\Form\OltPortType;
use App\Repository\OltPortRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/olt-port")
 */
class OltPortController extends AbstractController
{
    /**
     * @Route("/", name="olt_port_index", methods={"GET"})
     */
    public function index(OltPortRepository $oltPortRepository): Response
    {
        return $this->render('olt_port/index.html.twig', [
            'olt_ports' => $oltPortRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="olt_port_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $oltPort = new OltPort();
        $form = $this->createForm(OltPortType::class, $oltPort);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($oltPort);
            $entityManager->flush();

            return $this->redirectToRoute('olt_port_index');
        }

        return $this->render('olt_port/new.html.twig', [
            'olt_port' => $oltPort,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="olt_port_show", methods={"GET"})
     */
    public function show(OltPort $oltPort): Response
    {
        return $this->render('olt_port/show.html.twig', [
            'olt_port' => $oltPort,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="olt_port_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OltPort $oltPort): Response
    {
        $form = $this->createForm(OltPortType::class, $oltPort);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('olt_port_index', [
                'id' => $oltPort->getId(),
            ]);
        }

        return $this->render('olt_port/edit.html.twig', [
            'olt_port' => $oltPort,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="olt_port_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OltPort $oltPort): Response
    {
        if ($this->isCsrfTokenValid('delete'.$oltPort->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($oltPort);
            $entityManager->flush();
        }

        return $this->redirectToRoute('olt_port_index');
    }
}
