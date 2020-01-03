<?php

namespace App\Controller;

use App\Entity\DistributionBox;
use App\Form\DistributionBoxType;
use App\Repository\DistributionBoxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Serializer\CircularSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/distribution-box")
 */
class DistributionBoxController extends AbstractController
{
    /**
     * @Route("/", name="distribution_box_index", methods={"GET"})
     */
    public function index(DistributionBoxRepository $distributionBoxRepository): Response
    {
        return $this->render('distribution_box/index.html.twig', [
            'distribution_boxes' => $distributionBoxRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="distribution_box_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $distributionBox = new DistributionBox();
        $form = $this->createForm(DistributionBoxType::class, $distributionBox);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($distributionBox);
            $entityManager->flush();

            return $this->redirectToRoute('distribution_box_index');
        }

        return $this->render('distribution_box/new.html.twig', [
            'distribution_box' => $distributionBox,
            'form' => $form->createView(),
        ]);
    }
    
//    /**
//     * @Route("/generate-ports", name="distribution_box_create_ports", methods={"GET"})
//     */
//    public function generatePorts(
//            DistributionBoxRepository $distributionBoxRepository,
//            EntityManagerInterface $em) {
//        $dsBoxs = $distributionBoxRepository->findAll();
//        foreach ($dsBoxs as $dsBox) {
//            for ($i = 1; $i <= 24; $i++) {
//                $port = new \App\Entity\DistributionBoxPort();
//                $port->setNumber($i);
//                $port->setDistributionBox($dsBox);
//                $em->persist($port);
//            }
//        }
//        $em->flush();
//        
//        return new JsonResponse([
//            'message' => "Puertos creados correctamente."
//        ]);
//    }

    /**
     * @Route("/{id}", name="distribution_box_show", methods={"GET"})
     */
    public function show(
            DistributionBox $distributionBox, 
            Request $request,
            CircularSerializer $serializer): Response
    {
        if ($request->isXmlHttpRequest()) {
            $jsonObject = $serializer->serialize($distributionBox, ['distribution-box']);
            return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
        }
        
        return $this->render('distribution_box/show.html.twig', [
            'distribution_box' => $distributionBox,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="distribution_box_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DistributionBox $distributionBox): Response
    {
        $form = $this->createForm(DistributionBoxType::class, $distributionBox);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('distribution_box_index', [
                'id' => $distributionBox->getId(),
            ]);
        }

        return $this->render('distribution_box/edit.html.twig', [
            'distribution_box' => $distributionBox,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="distribution_box_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DistributionBox $distributionBox): Response
    {
        if ($this->isCsrfTokenValid('delete'.$distributionBox->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($distributionBox);
            $entityManager->flush();
        }

        return $this->redirectToRoute('distribution_box_index');
    }
    
    /**
     * @Route("/save-distribution-box", name="map-save-distribution-box", methods={"POST"})
     */
    public function saveDistributionBoxAction(
            EntityManagerInterface $em,
            Request $request,
            CircularSerializer $serializer) {

        $ds = $em->getRepository(\App\Entity\DistributionBox::class)->findOneBy(array(
            "id" => $request->get('distribution-box')
        ));
        $icon = $em->getRepository(\App\Entity\Icon::class)->findOneBy(array(
            'element' => DistributionBox::class
        ));
        if (!$icon) {
            return new JsonResponse([
                'message'   =>  "Debe definir un icono para la caja de distribución antes de añadirla al mapa."
            ], 400);
        }
        $ds
                ->setLatitude($request->get('latitude'))
                ->setLongitude($request->get('longitude'))
                ->setIcon($icon->getIcon());

        $em->persist($ds);
        $em->flush();

        return new JsonResponse([
            'type' => DistributionBox::class,
            'message' => "Caja de distribución guardada correctamente.",
            'data' => json_decode($serializer->serialize($ds, ['map']))
        ]);
    }
    
    /**
     * @Route("/{id}", name="distribution_box_create_conexion", methods={"POST"})
     */
    public function createConexion(
            Request $request,
            DistributionBox $dsBox,
            EntityManagerInterface $em) {
        $data = json_decode($request->getContent(), true)['data'];

        $fiber = $em->getRepository(\App\Entity\Fiber::class)->findOneBy(array(
            "id" => intval($data['fiberId'])
        ));
        $dsBoxPort = $em->getRepository(\App\Entity\DistributionBoxPort::class)->findOneBy(array(
            "id" => intval($data['conectorId'])
        ));

        
        $dsBoxPort->setFiber($fiber);
        $em->persist($dsBoxPort);
        $em->flush();

        return new JsonResponse([
            'message' => "Conexión realizada correctamente."
        ]);
    }
    
    
}
