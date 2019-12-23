<?php

namespace App\Controller;

use App\Entity\Wire;
use App\Form\WireType;
use App\Repository\WireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Serializer\CircularSerializer;

/**
 * @Route("/wire")
 */
class WireController extends AbstractController {

    /**
     * @Route("/", name="wire_index", methods={"GET"})
     */
    public function index(
            WireRepository $wireRepository,
            Request $request,
            CircularSerializer $serializer): Response {
        if ($request->isXmlHttpRequest()) {
            $jsonObject = $serializer->serialize($wireRepository->findAll(), ['wire']);
            return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
        }

        return $this->render('wire/index.html.twig', [
                    'wires' => $wireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="wire_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response {
        $wire = new Wire();
        $form = $this->createForm(WireType::class, $wire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            \App\EntityPattern\PatternGeneratorFactory::make($entityManager, $wire)->generate();
            $entityManager->persist($wire);
            $entityManager->flush();

            return $this->redirectToRoute('wire_index');
        }

        return $this->render('wire/new.html.twig', [
                    'wire' => $wire,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="wire_show", methods={"GET"})
     */
    public function show(
            Request $request,
            Wire $wire,
            CircularSerializer $serializer): Response {

        if ($request->isXmlHttpRequest()) {
            $jsonObject = $serializer->serialize($wire, ['wire', 'form']);
            return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
        }

        return $this->render('wire/show.html.twig', [
                    'wire' => $wire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="wire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Wire $wire): Response {
        $form = $this->createForm(WireType::class, $wire);
        $form->remove('wirePattern');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('wire_index');
        }

        return $this->render('wire/edit.html.twig', [
                    'wire' => $wire,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="wire_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Wire $wire): Response {

        if ($request->isXmlHttpRequest()) {
            if (!$this->getUser()->isAdmin()) {
                return new JsonResponse([
                    'message' => 'No tienes permisos para realizar esta acción.'
                ], 403);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $wire->deleteFusionAndPasants();
            $entityManager->remove($wire);
            $entityManager->flush();

            return new JsonResponse([
                'message' => 'Cable eliminado correctamente.'
            ]);
        }

        if ($this->isCsrfTokenValid('delete' . $wire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($wire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('wire_index');
    }

    /**
     * @Route("/save-wire", name="map-save-wire", methods={"POST"})
     */
    public function saveWireAction(
            EntityManagerInterface $em,
            Request $request,
            CircularSerializer $serializer) {

        $layerGroup = $em->getRepository(\App\Entity\LayerGroup::class)->findOneBy(array(
            "id" => $request->get('layer')
        ));
        $wirePattern = $em->getRepository(\App\Entity\WirePattern::class)->findOneBy(array(
            "id" => $request->get('wire-pattern')
        ));
        $wire = new \App\Entity\Wire();
        $wire
                ->setName($request->get('name'))
                ->setCoordinates(json_decode($request->get('coordinates')))
                ->setLongitude($request->get('distance'))
                ->setWirePattern($wirePattern)
                ->setLayerGroup($layerGroup);
        \App\EntityPattern\PatternGeneratorFactory::make($em, $wire)->generate();
        $em->persist($wire);
        $em->flush();

        return new JsonResponse([
            'type' => Wire::class,
            'message' => "Cable guardado correctamente.",
            'data' => json_decode($serializer->serialize($wire, ['map']))
        ]);
    }

}
