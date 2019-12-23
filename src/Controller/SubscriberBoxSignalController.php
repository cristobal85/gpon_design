<?php

namespace App\Controller;

use App\Entity\SubscriberBoxSignal;
use App\Form\SubscriberBoxSignalType;
use App\Repository\SubscriberBoxSignalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/subscriber-box-signal")
 */
class SubscriberBoxSignalController extends AbstractController
{
    /**
     * @Route("/", name="subscriber_box_signal_index", methods={"GET"})
     */
    public function index(SubscriberBoxSignalRepository $subscriberBoxSignalRepository): Response
    {
        return $this->render('subscriber_box_signal/index.html.twig', [
            'subscriber_box_signals' => $subscriberBoxSignalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="subscriber_box_signal_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $subscriberBoxSignal = new SubscriberBoxSignal();
        $form = $this->createForm(SubscriberBoxSignalType::class, $subscriberBoxSignal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subscriberBoxSignal);
            $entityManager->flush();

            return $this->redirectToRoute('subscriber_box_signal_index');
        }

        return $this->render('subscriber_box_signal/new.html.twig', [
            'subscriber_box_signal' => $subscriberBoxSignal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="subscriber_box_signal_show", methods={"GET"})
     */
    public function show(SubscriberBoxSignal $subscriberBoxSignal): Response
    {
        return $this->render('subscriber_box_signal/show.html.twig', [
            'subscriber_box_signal' => $subscriberBoxSignal,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="subscriber_box_signal_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SubscriberBoxSignal $subscriberBoxSignal): Response
    {
        $form = $this->createForm(SubscriberBoxSignalType::class, $subscriberBoxSignal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('subscriber_box_signal_index', [
                'id' => $subscriberBoxSignal->getId(),
            ]);
        }

        return $this->render('subscriber_box_signal/edit.html.twig', [
            'subscriber_box_signal' => $subscriberBoxSignal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="subscriber_box_signal_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SubscriberBoxSignal $subscriberBoxSignal): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subscriberBoxSignal->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($subscriberBoxSignal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('subscriber_box_signal_index');
    }
}
