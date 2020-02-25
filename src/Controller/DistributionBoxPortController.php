<?php

namespace App\Controller;

use App\Entity\DistributionBoxPort;
use App\Form\DistributionBoxPortType;
use App\Repository\DistributionBoxPortRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Serializer\CircularSerializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use \Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/distribution-box-port")
 */
class DistributionBoxPortController extends AbstractController
{
    /**
     * @Route("/", name="distribution_box_port_index", methods={"GET"})
     */
    public function index(DistributionBoxPortRepository $distributionBoxPortRepository): Response
    {
        return $this->render('distribution_box_port/index.html.twig', [
            'distribution_box_ports' => $distributionBoxPortRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="distribution_box_port_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $distributionBoxPort = new DistributionBoxPort();
        $form = $this->createForm(DistributionBoxPortType::class, $distributionBoxPort);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($distributionBoxPort);
            $entityManager->flush();

            return $this->redirectToRoute('distribution_box_port_index');
        }

        return $this->render('distribution_box_port/new.html.twig', [
            'distribution_box_port' => $distributionBoxPort,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="distribution_box_port_show", methods={"GET"})
     */
    public function show(
            DistributionBoxPort $distributionBoxPort,
            Request $request,
            CircularSerializer $serializer): Response
    {
        if ($request->isXmlHttpRequest()) {
            $jsonObject = $serializer->serialize($distributionBoxPort, ['path']);

            return new Response($jsonObject);
        }
        
        return $this->render('distribution_box_port/show.html.twig', [
            'distribution_box_port' => $distributionBoxPort,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="distribution_box_port_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, DistributionBoxPort $distributionBoxPort): Response
    {
        $form = $this->createForm(DistributionBoxPortType::class, $distributionBoxPort);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('distribution_box_port_index');
        }

        return $this->render('distribution_box_port/edit.html.twig', [
            'distribution_box_port' => $distributionBoxPort,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="distribution_box_port_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, DistributionBoxPort $distributionBoxPort): Response
    {
        if ($this->isCsrfTokenValid('delete'.$distributionBoxPort->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($distributionBoxPort);
            $entityManager->flush();
        }

        return $this->redirectToRoute('distribution_box_port_index');
    }
    
    /**
     * @Route("/{id}/disconnect", name="distribution_box_port_disconnect_port", methods={"PUT"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function disconnectPort(
            DistributionBoxPort $distributionBoxPort,
            EntityManagerInterface $em): Response
    {
        $distributionBoxPort->setFiber(null);
        $em->persist($distributionBoxPort);
        $em->flush();

        return new JsonResponse([
            'message' => "Puerto desconectado correctamente."
        ]);
    }
}
