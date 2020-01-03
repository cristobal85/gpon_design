<?php

namespace App\Controller;

use App\Entity\LayerGroup;
use App\Form\LayerGroupType;
use App\Repository\LayerGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Serializer\CircularSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/layer-group")
 */
class LayerGroupController extends AbstractController
{
    /**
     * @Route("/", name="layer_group_index", methods={"GET"})
     */
    public function index(LayerGroupRepository $layerGroupRepository): Response
    {
        return $this->render('layer_group/index.html.twig', [
            'layer_groups' => $layerGroupRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="layer_group_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $layerGroup = new LayerGroup();
        $form = $this->createForm(LayerGroupType::class, $layerGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($layerGroup);
            $entityManager->flush();

            return $this->redirectToRoute('layer_group_index');
        }

        return $this->render('layer_group/new.html.twig', [
            'layer_group' => $layerGroup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="layer_group_show", methods={"GET"})
     */
    public function show(LayerGroup $layerGroup): Response
    {
        return $this->render('layer_group/show.html.twig', [
            'layer_group' => $layerGroup,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="layer_group_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, LayerGroup $layerGroup): Response
    {
        $form = $this->createForm(LayerGroupType::class, $layerGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('layer_group_index', [
                'id' => $layerGroup->getId(),
            ]);
        }

        return $this->render('layer_group/edit.html.twig', [
            'layer_group' => $layerGroup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="layer_group_delete", methods={"DELETE"})
     */
    public function delete(Request $request, LayerGroup $layerGroup): Response
    {
        if ($this->isCsrfTokenValid('delete'.$layerGroup->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($layerGroup);
            $entityManager->flush();
        }

        return $this->redirectToRoute('layer_group_index');
    }
    
        /**
     * @Route("/save-layer", name="map-save-layer", methods={"POST"})
     */
    public function saveLayerAction(
            EntityManagerInterface $em,
            Request $request,
            CircularSerializer $serializer) {

        $layer = $em->getRepository(\App\Entity\LayerGroup::class)->findOneBy(array(
            "id" => $request->get('layer')
        ));
        $layer
                ->setCoordinates(json_decode($request->get('coordinates')))
                ->setWeight(LayerGroup::DEFAULT_WEIGHT);

        $em->persist($layer);
        $em->flush();

        return new JsonResponse([
            'type' => LayerGroup::class,
            'message' => "Capa delimitada correctamente.",
            'data' => json_decode($serializer->serialize($layer, ['map']))
        ]);
    }
}
