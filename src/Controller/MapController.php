<?php

namespace App\Controller;

use App\Entity\Map;
use App\Form\MapType;
use App\Repository\MapRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Serializer\CircularSerializer;
use App\Repository\DistributionBoxRepository;
use App\Repository\SubscriberBoxRepository;
use App\Repository\SubscriberBoxExtRepository;
use App\Repository\WireRepository;
use App\Repository\TorpedoRepository;
use App\Repository\NoteRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class MapController extends AbstractController
{
    /**
     * @Route("/cpd-map/", name="cpd_map_index", methods={"GET"})
     */
    public function index(MapRepository $mapRepository): Response
    {
        return $this->render('map/index.html.twig', [
            'maps' => $mapRepository->findAll(),
        ]);
    }

    /**
     * @Route("/cpd-map/new", name="cpd_map_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $map = new Map();
        $form = $this->createForm(MapType::class, $map);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($map);
            $entityManager->flush();

            return $this->redirectToRoute('cpd_map_index');
        }

        return $this->render('map/new.html.twig', [
            'map' => $map,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/cpd-map/{id}", name="cpd_map_show", methods={"GET"})
     */
    public function show(Map $map): Response
    {
        return $this->render('map/show.html.twig', [
            'map' => $map,
        ]);
    }

    /**
     * @Route("/cpd-map/{id}/edit", name="cpd_map_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Map $map): Response
    {
        $form = $this->createForm(MapType::class, $map);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cpd_map_index');
        }

        return $this->render('map/edit.html.twig', [
            'map' => $map,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/cpd-map/{id}", name="cpd_map_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Map $map): Response
    {
        if ($this->isCsrfTokenValid('delete'.$map->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($map);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cpd_map_index');
    }
    
    
     /**
     * @Route("/map", name="map")
     */
    public function showGeoMap() {
        return $this->render('map/geo-map.html.twig');
    }

    /**
     * @Route("/map/layers", name="map-layers")
     */
    public function getLayersAction(
            EntityManagerInterface $em, 
            CircularSerializer $serializer
            ) {
        $layerGroupModels = $em->getRepository(\App\Entity\LayerGroup::class)->findBy(
                [],
                ['position' => 'ASC']
        );
        
        $jsonObject = $serializer->serialize($layerGroupModels, ['map']);

        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/map/cpd", name="map-cpd")
     */
    public function getCpdAction(
            EntityManagerInterface $em, 
            CircularSerializer $serializer) {
        $cpd = $em->getRepository(\App\Entity\Cpd::class)->findAll()[0];

        $jsonObject = $serializer->serialize($cpd, ['map']);

        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/map/distribution-box", name="map-get-distribution-box", methods={"GET"})
     */
    public function getDistributionBoxAction(
            DistributionBoxRepository $dsRep,
            CircularSerializer $serializer) {
        $distributionBoxes = $dsRep->findBy(array(
            'latitude' => null
        ));

        $jsonObject = $serializer->serialize($distributionBoxes, ['distribution-box']);

        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/map/subscriber-box", name="map-get-subscriber-box", methods={"GET"})
     */
    public function getSubscriberBoxAction(
            SubscriberBoxRepository $subsRep,
            CircularSerializer $serializer) {
        $subscriberBoxes = $subsRep->findBy(array(
            'latitude' => null
        ));

        $jsonObject = $serializer->serialize($subscriberBoxes, ['subscriber-box']);

        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/map/wire", name="map-get-wire", methods={"GET"})
     */
    public function getWireAction(
            WireRepository $wireRep,
            CircularSerializer $serializer) {
        $wires = $wireRep->findAll();

        $jsonObject = $serializer->serialize($wires, ['map']);

        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/map/subscriber-box-ext", name="map-get-subscriber-box-ext", methods={"GET"})
     */
    public function getSubscriberBoxExtAction(
            SubscriberBoxExtRepository $subBoxExtRep,
            CircularSerializer $serializer) {
        $subscriberBoxesExt = $subBoxExtRep->findBy(array(
            'latitude' => null
        ));

        $jsonObject = $serializer->serialize($subscriberBoxesExt, ['subscriber-box-ext']);

        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }
    
    /**
     * @Route("/map/torpedo", name="map-get-torpedo", methods={"GET"})
     */
    public function getTorpedoAction(
            TorpedoRepository $torpedoRep, 
            SerializerInterface $serializer) {
        $torpedos = $torpedoRep->findAll();

        $jsonObject = $serializer->serialize($torpedos, 'json', ['torpedo']);

        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }
    
    /**
     * @Route("/map/notes", name="map-get-notes", methods={"GET"})
     */
    public function getNotesAction(
            NoteRepository $noteRep, 
            CircularSerializer $serializer) {
        $notes = $noteRep->findBy(['closed' => false]);
        
        $jsonObject = $serializer->serialize($notes, ['map']);

        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }
    

    /**
     * @Route("/map/update-subscriber-box", name="map-update-subscriber-box", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function updateSubscriberBoxAction(EntityManagerInterface $em, Request $request) {

        $data = json_decode($request->getContent(), true)['data'];

        $subscriber = $em->getRepository(\App\Entity\SubscriberBox::class)->findOneBy(array(
            "id" => $data['id']
        ));
        $subscriber
                ->setLatitude(floatval($data['latitude']))
                ->setLongitude(floatval($data['longitude']));

        $em->persist($subscriber);
        $em->flush();

        return new \Symfony\Component\HttpFoundation\JsonResponse([
            'message' => "Caja de abonado modificada correctamente."
        ]);
    }

    /**
     * @Route("/map/update-subscriber-box-ext", name="map-update-subscriber-box-ext", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function updateSubscriberBoxExtAction(EntityManagerInterface $em, Request $request) {

        $data = json_decode($request->getContent(), true)['data'];

        $subscriberExt = $em->getRepository(\App\Entity\SubscriberBoxExt::class)->findOneBy(array(
            "id" => $data['id']
        ));
        $subscriberExt
                ->setLatitude(floatval($data['latitude']))
                ->setLongitude(floatval($data['longitude']));

        $em->persist($subscriberExt);
        $em->flush();

        return new \Symfony\Component\HttpFoundation\JsonResponse([
            'message' => "Caja de extensión modificada correctamente."
        ]);
    }

    /**
     * @Route("/map/update-distribution-box", name="map-update-distribution-box", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function updateDistributionBoxAction(EntityManagerInterface $em, Request $request) {

        $data = json_decode($request->getContent(), true)['data'];

        $ds = $em->getRepository(\App\Entity\DistributionBox::class)->findOneBy(array(
            "id" => $data['id']
        ));
        $ds
                ->setLatitude(floatval($data['latitude']))
                ->setLongitude(floatval($data['longitude']));

        $em->persist($ds);
        $em->flush();

        return new \Symfony\Component\HttpFoundation\JsonResponse([
            'message' => "Caja de distribución modificada correctamente."
        ]);
    }

    /**
     * @Route("/map/update-layer", name="map-update-layer", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function updateLayerAction(EntityManagerInterface $em, Request $request) {

        $data = json_decode($request->getContent(), true)['data'];

        $layer = $em->getRepository(\App\Entity\LayerGroup::class)->findOneBy(array(
            "id" => $data['id']
        ));
        $layer
                ->setCoordinates($data['coordinates']);

        $em->persist($layer);
        $em->flush();

        return new \Symfony\Component\HttpFoundation\JsonResponse([
            'message' => "Capa modificada correctamente."
        ]);
    }

    /**
     * @Route("/map/update-wire", name="map-update-wire", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function updateWireAction(EntityManagerInterface $em, Request $request) {

        $data = json_decode($request->getContent(), true)['data'];

        $wire = $em->getRepository(\App\Entity\Wire::class)->findOneBy(array(
            "id" => $data['id']
        ));
        $wire
                ->setCoordinates($data['coordinates']);

        $em->persist($wire);
        $em->flush();

        return new \Symfony\Component\HttpFoundation\JsonResponse([
            'message' => "Cable modificado correctamente."
        ]);
    }

    /**
     * @Route("/map/update-cpd", name="map-update-cpd", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function updateCpdAction(EntityManagerInterface $em, Request $request) {

        $data = json_decode($request->getContent(), true)['data'];

        $cpd = $em->getRepository(\App\Entity\Cpd::class)->findOneBy(array(
            "id" => $data['id']
        ));
        $cpd
                ->setLatitude(floatval($data['latitude']))
                ->setLongitude(floatval($data['longitude']));

        $em->persist($cpd);
        $em->flush();

        return new \Symfony\Component\HttpFoundation\JsonResponse([
            'message' => "CPD modificado correctamente."
        ]);
    }
    
    /**
     * @Route("/map/update-torpedo", name="map-update-torpedo", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function updateTorpedoAction(EntityManagerInterface $em, Request $request) {

        $data = json_decode($request->getContent(), true)['data'];

        $torpedo = $em->getRepository(\App\Entity\Torpedo::class)->findOneBy(array(
            "id" => $data['id']
        ));
        $torpedo
                ->setLatitude(floatval($data['latitude']))
                ->setLongitude(floatval($data['longitude']));

        $em->persist($torpedo);
        $em->flush();

        return new \Symfony\Component\HttpFoundation\JsonResponse([
            'message' => "Torpedo modificado correctamente."
        ]);
    }
    
}
