<?php

namespace App\Controller;

use App\Entity\Torpedo;
use App\Form\TorpedoType;
use App\Repository\TorpedoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Serializer\CircularSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/torpedo")
 */
class TorpedoController extends AbstractController {

    /**
     * @Route("/", name="torpedo_index", methods={"GET"})
     */
    public function index(TorpedoRepository $torpedoRepository): Response {
        return $this->render('torpedo/index.html.twig', [
                    'torpedos' => $torpedoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="torpedo_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response {
        $torpedo = new Torpedo();
        $form = $this->createForm(TorpedoType::class, $torpedo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($torpedo);
            $entityManager->flush();

            return $this->redirectToRoute('torpedo_index');
        }

        return $this->render('torpedo/new.html.twig', [
                    'torpedo' => $torpedo,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="torpedo_show", methods={"GET"})
     */
    public function show(
            Torpedo $torpedo,
            Request $request,
            CircularSerializer $serializer): Response {
        if ($request->isXmlHttpRequest()) {
            $jsonOject = $serializer->serialize($torpedo, ['torpedo']);
            return new Response($jsonOject, 200, ['Content-Type' => 'application/json']);
        }

        return $this->render('torpedo/show.html.twig', [
                    'torpedo' => $torpedo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="torpedo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Torpedo $torpedo): Response {
        $form = $this->createForm(TorpedoType::class, $torpedo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('torpedo_index');
        }

        return $this->render('torpedo/edit.html.twig', [
                    'torpedo' => $torpedo,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="torpedo_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Torpedo $torpedo): Response {
        if ($this->isCsrfTokenValid('delete' . $torpedo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($torpedo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('torpedo_index');
    }

    /**
     * @Route("/save-torpedo", name="map-save-torpedo", methods={"POST"})
     */
    public function saveTorpedoAction(
            EntityManagerInterface $em,
            Request $request,
            CircularSerializer $serializer) {

        $layer = $em->getRepository(\App\Entity\LayerGroup::class)->findOneBy(array(
            "id" => $request->get('layer')
        ));
        $icon = $em->getRepository(\App\Entity\Icon::class)->findOneBy(array(
            'element' => Torpedo::class
        ));
        if (!$icon) {
            return new JsonResponse([
                'message'   =>  "Debe definir un icono para el torpedo antes de añadirlo al mapa."
            ], 400);
        }
        $torpedo = new \App\Entity\Torpedo();
        $torpedo
                ->setLatitude($request->get('latitude'))
                ->setLongitude($request->get('longitude'))
                ->setName($request->get('name'))
                ->setLayerGroup($layer)
                ->setIcon($icon->getIcon());

        $em->persist($torpedo);
        $em->flush();

        return new JsonResponse([
            'type' => Torpedo::class,
            'message' => "Torpedo creado correctamente.",
            'data' => json_decode($serializer->serialize($torpedo, ['map']))
        ]);
    }

}
