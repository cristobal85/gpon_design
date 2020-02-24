<?php

namespace App\Controller;

use App\Entity\PatchPanelSlotConector;
use App\Form\PatchPanelSlotConectorType;
use App\Repository\PatchPanelSlotConectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Serializer\CircularSerializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/patch-panel-slot-conector")
 */
class PatchPanelSlotConectorController extends AbstractController {

    /**
     * @Route("/", name="patch_panel_slot_conector_index", methods={"GET"})
     */
    public function index(PatchPanelSlotConectorRepository $patchPanelSlotConectorRepository): Response {
        return $this->render('patch_panel_slot_conector/index.html.twig', [
                    'patch_panel_slot_conectors' => $patchPanelSlotConectorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="patch_panel_slot_conector_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response {
        $patchPanelSlotConector = new PatchPanelSlotConector();
        $form = $this->createForm(PatchPanelSlotConectorType::class, $patchPanelSlotConector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patchPanelSlotConector);
            $entityManager->flush();

            return $this->redirectToRoute('patch_panel_slot_conector_index');
        }

        return $this->render('patch_panel_slot_conector/new.html.twig', [
                    'patch_panel_slot_conector' => $patchPanelSlotConector,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="patch_panel_slot_conector_show", methods={"GET"})
     */
    public function show(
            PatchPanelSlotConector $patchPanelSlotConector,
            Request $request,
            CircularSerializer $serializer): Response {
        if ($request->isXmlHttpRequest()) {
            $jsonObject = $serializer->serialize($patchPanelSlotConector, ['map', 'path']);

            return new Response($jsonObject);
        }

        return $this->render('patch_panel_slot_conector/show.html.twig', [
                    'patch_panel_slot_conector' => $patchPanelSlotConector,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="patch_panel_slot_conector_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PatchPanelSlotConector $patchPanelSlotConector): Response {
        $form = $this->createForm(PatchPanelSlotConectorType::class, $patchPanelSlotConector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('patch_panel_slot_conector_index', [
                        'id' => $patchPanelSlotConector->getId(),
            ]);
        }

        return $this->render('patch_panel_slot_conector/edit.html.twig', [
                    'patch_panel_slot_conector' => $patchPanelSlotConector,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="patch_panel_slot_conector_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PatchPanelSlotConector $patchPanelSlotConector): Response {
        if ($this->isCsrfTokenValid('delete' . $patchPanelSlotConector->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($patchPanelSlotConector);
            $entityManager->flush();
        }

        return $this->redirectToRoute('patch_panel_slot_conector_index');
    }

    /**
     * @Route("/{id}", name="patch_panel_slot_conector_conexion", methods={"POST"})
     */
    public function createConexion(
            PatchPanelSlotConector $patchPanelSlotConector,
            Request $request,
            EntityManagerInterface $em): Response {
        if ($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent(), true)['data'];

            $fiber = $em->getRepository(\App\Entity\Fiber::class)->findOneBy(array(
                "id" => intval($data['fiberId'])
            ));


            $patchPanelSlotConector->setFiber($fiber);
            $em->persist($patchPanelSlotConector);
            $em->flush();

            return new JsonResponse([
                'message' => "Conexión realizada correctamente."
            ]);
        }

        return $this->render('patch_panel_slot_conector/show.html.twig', [
                    'patch_panel_slot_conector' => $patchPanelSlotConector,
        ]);
    }
    
    /**
     * @Route("/{id}", name="patch_panel_slot_conector_description", methods={"PUT"})
     */
    public function saveDescription(
            PatchPanelSlotConector $patchPanelSlotConector,
            Request $request,
            EntityManagerInterface $em): Response {
        if ($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent(), true)['data'];

            $description = $data['description'];


            $patchPanelSlotConector->setDescription($description);
            $em->persist($patchPanelSlotConector);
            $em->flush();

            return new JsonResponse([
                'message' => "Descripción guardada correctamente."
            ]);
        }

        return $this->render('patch_panel_slot_conector/show.html.twig', [
                    'patch_panel_slot_conector' => $patchPanelSlotConector,
        ]);
    }
    
    /**
     * @Route("/{id}/disconnect", name="patch_panel_slot_conector_disconnect_port", methods={"PUT"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function disconnectPort(
            PatchPanelSlotConector $patchPanelSlotConector,
            EntityManagerInterface $em): Response
    {
        $patchPanelSlotConector->setFiber(null);
        $em->persist($patchPanelSlotConector);
        $em->flush();

        return new JsonResponse([
            'message' => "Puerto desconectado correctamente."
        ]);
    }

}
