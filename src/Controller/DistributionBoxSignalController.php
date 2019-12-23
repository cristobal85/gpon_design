<?php

namespace App\Controller;

use App\Entity\DistributionBoxSignal;
use App\Form\DistributionBoxSignalType;
use App\Repository\DistributionBoxSignalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/distribution_box_signal")
 */
class DistributionBoxSignalController extends AbstractController
{
    /**
     * @Route("/", name="distribution_box_signal_index", methods={"GET"})
     */
    public function index(DistributionBoxSignalRepository $distributionBoxSignalRepository): Response
    {
        return $this->render('distribution_box_signal/index.html.twig', [
            'distribution_box_signals' => $distributionBoxSignalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="distribution_box_signal_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $distributionBoxSignal = new DistributionBoxSignal();
        $form = $this->createForm(DistributionBoxSignalType::class, $distributionBoxSignal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($distributionBoxSignal);
            $entityManager->flush();

            return $this->redirectToRoute('distribution_box_signal_index');
        }

        return $this->render('distribution_box_signal/new.html.twig', [
            'distribution_box_signal' => $distributionBoxSignal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="distribution_box_signal_show", methods={"GET"})
     */
    public function show(DistributionBoxSignal $distributionBoxSignal): Response
    {
        return $this->render('distribution_box_signal/show.html.twig', [
            'distribution_box_signal' => $distributionBoxSignal,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="distribution_box_signal_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DistributionBoxSignal $distributionBoxSignal): Response
    {
        $form = $this->createForm(DistributionBoxSignalType::class, $distributionBoxSignal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('distribution_box_signal_index', [
                'id' => $distributionBoxSignal->getId(),
            ]);
        }

        return $this->render('distribution_box_signal/edit.html.twig', [
            'distribution_box_signal' => $distributionBoxSignal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="distribution_box_signal_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DistributionBoxSignal $distributionBoxSignal): Response
    {
        if ($this->isCsrfTokenValid('delete'.$distributionBoxSignal->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($distributionBoxSignal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('distribution_box_signal_index');
    }
}
