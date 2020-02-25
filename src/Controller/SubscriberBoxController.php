<?php

namespace App\Controller;

use App\Entity\SubscriberBox;
use App\Form\SubscriberBoxType;
use App\Repository\SubscriberBoxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Serializer\CircularSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/subscriber-box")
 */
class SubscriberBoxController extends AbstractController
{
    /**
     * @Route("/", name="subscriber_box_index", methods={"GET"})
     */
    public function index(SubscriberBoxRepository $subscriberBoxRepository): Response
    {
        return $this->render('subscriber_box/index.html.twig', [
            'subscriber_boxes' => $subscriberBoxRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="subscriber_box_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $subscriberBox = new SubscriberBox();
        $form = $this->createForm(SubscriberBoxType::class, $subscriberBox);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subscriberBox);
            $entityManager->flush();

            return $this->redirectToRoute('subscriber_box_index');
        }

        return $this->render('subscriber_box/new.html.twig', [
            'subscriber_box' => $subscriberBox,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="subscriber_box_show", methods={"GET"})
     */
    public function show(
            SubscriberBox $subscriberBox,
            Request $request,
            CircularSerializer $serializer): Response
    {
        if ($request->isXmlHttpRequest()) {
            $jsonObject = $serializer->serialize($subscriberBox, ['subscriber-box']);
            return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
        }
        
        return $this->render('subscriber_box/show.html.twig', [
            'subscriber_box' => $subscriberBox,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="subscriber_box_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SubscriberBox $subscriberBox): Response
    {
        $form = $this->createForm(SubscriberBoxType::class, $subscriberBox);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('subscriber_box_index', [
                'id' => $subscriberBox->getId(),
            ]);
        }

        return $this->render('subscriber_box/edit.html.twig', [
            'subscriber_box' => $subscriberBox,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="subscriber_box_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, SubscriberBox $subscriberBox): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subscriberBox->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($subscriberBox);
            $entityManager->flush();
        }

        return $this->redirectToRoute('subscriber_box_index');
    }
    
    
    /**
     * @Route("/save-subscriber-box", name="map-save-subscriber-box", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function saveSubscriberBoxAction(
            EntityManagerInterface $em,
            Request $request,
            CircularSerializer $serializer
            ) {

        $data = json_decode($request->getContent(), true)['data'];
        $subscriber = $em->getRepository(SubscriberBox::class)->findOneBy(array(
            "id" => $data['subscriber-box']
        ));
        $icon = $em->getRepository(\App\Entity\Icon::class)->findOneBy(array(
            'element' => SubscriberBox::class
        ));
        if (!$icon) {
            return new JsonResponse([
                'message'   =>  "Debe definir un icono para la caja de abonado antes de añadirla al mapa."
            ], 400);
        }
        
        $subscriber
                ->setLatitude($data['latitude'])
                ->setLongitude($data['longitude'])
                ->setIcon($icon->getIcon());

        $em->persist($subscriber);
        $em->flush();

        return new JsonResponse([
            'type' => SubscriberBox::class,
            'message' => "Caja de abonado guardada correctamente.",
            'data' => json_decode($serializer->serialize($subscriber, ['map']))
        ]);
    }
}
