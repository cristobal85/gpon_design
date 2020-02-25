<?php

namespace App\Controller;

use App\Entity\TorpedoFusion;
use App\Form\TorpedoFusionType;
use App\Repository\TorpedoFusionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Doctrine\ORM\EntityManagerInterface;
use App\Entity\Torpedo;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\TorpedoPassantRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/torpedo-fusion")
 */
class TorpedoFusionController extends AbstractController {

    /**
     * @Route("/", name="torpedo_fusion_index", methods={"GET"})
     */
    public function index(TorpedoFusionRepository $torpedoFusionRepository): Response {
        return $this->render('torpedo_fusion/index.html.twig', [
                    'torpedo_fusions' => $torpedoFusionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="torpedo_fusion_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response {
        $torpedoFusion = new TorpedoFusion();
        $form = $this->createForm(TorpedoFusionType::class, $torpedoFusion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($torpedoFusion);
            $entityManager->flush();

            return $this->redirectToRoute('torpedo_fusion_index');
        }

        return $this->render('torpedo_fusion/new.html.twig', [
                    'torpedo_fusion' => $torpedoFusion,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="torpedo_fusion_show", methods={"GET"})
     */
    public function show(TorpedoFusion $torpedoFusion): Response {
        return $this->render('torpedo_fusion/show.html.twig', [
                    'torpedo_fusion' => $torpedoFusion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="torpedo_fusion_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, TorpedoFusion $torpedoFusion): Response {
        $form = $this->createForm(TorpedoFusionType::class, $torpedoFusion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('torpedo_fusion_index');
        }

        return $this->render('torpedo_fusion/edit.html.twig', [
                    'torpedo_fusion' => $torpedoFusion,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="torpedo_fusion_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, TorpedoFusion $torpedoFusion): Response {
        $entityManager = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            if (!$this->getUser()->isAdmin()) {
                return new JsonResponse([
                    'message' => "No tiene permisos para realizar esta acción."
                        ], Response::HTTP_FORBIDDEN);
            }
            $entityManager->remove($torpedoFusion);
            $entityManager->flush();
            return new JsonResponse([
                'message' => "Fusión eliminada correctamente."
            ]);
        }
        if ($this->isCsrfTokenValid('delete' . $torpedoFusion->getId(), $request->request->get('_token'))) {

            $entityManager->remove($torpedoFusion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('torpedo_fusion_index');
    }

    /**
     * @Route("/{id}", name="torpedo_fusion_create", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function createFusion(
            Request $request,
            Torpedo $torpedo,
            EntityManagerInterface $em,
            ValidatorInterface $validator,
            TorpedoPassantRepository $torpedoRep) {
        if (!$this->getUser()->isAdmin()) {
            return new JsonResponse([
                'message' => "No tiene permisos para realizar esta acción."
                    ], Response::HTTP_FORBIDDEN);
        }
        $data = json_decode($request->getContent(), true)['data'];

        $fiber1 = $em->getRepository(\App\Entity\Fiber::class)->findOneBy(array(
            "id" => intval($data['fiber1Id'])
        ));
        $fiber2 = $em->getRepository(\App\Entity\Fiber::class)->findOneBy(array(
            "id" => intval($data['fiber2Id'])
        ));

        // TODO: Refactorin todo esto y pensar patrón
        $torpedoFusions = $em->getRepository(TorpedoFusion::class)->findAll();
        foreach ($torpedoFusions as $fusion) {
            foreach ($fusion->getFibers() as $fiber) {
                if (($fiber == $fiber1 || $fiber == $fiber2) && $torpedo == $fusion->getTorpedo()) {
                    return new JsonResponse([
                        'message' => "La fibra (" . $fiber . ") ya se encuentra fusionada en el torpedo (" . $fusion->getTorpedo() . ")."
                            ], 400);
                }
            }
        }
        // Delete from pasants
        $torpedoPassants = $fiber1->getTorpedoPassants();
        foreach ($torpedoPassants as $torpedoPassant) {
            if ($torpedoPassant->getTorpedo() === $torpedo) {
                $em->remove($torpedoPassant);
            }
        }
        $torpedoPassants = $fiber2->getTorpedoPassants();
        foreach ($torpedoPassants as $torpedoPassant) {
            if ($torpedoPassant->getTorpedo() === $torpedo) {
                $em->remove($torpedoPassant);
            }
        }
        
        // Generate torpedo fusion
        $torpedoFusion = new TorpedoFusion();
        $torpedoFusion->addFiber($fiber1)->addFiber($fiber2);



        $torpedoErrors = $validator->validate($torpedoFusion);
        $fiber1Errors = $validator->validate($fiber1);
        $fiber2Errors = $validator->validate($fiber2);

        $errorsString = "";
        if (count($torpedoErrors) > 0) {
            $errorsString = (string) $torpedoErrors;
        }
        if (count($fiber1Errors) > 0) {
            $errorsString = (string) $fiber1Errors;
        }
        if (count($fiber2Errors) > 0) {
            $errorsString = (string) $fiber2Errors;
        }
        if (!empty($errorsString)) {
            return new JsonResponse([
                'message' => $errorsString
                    ], 400);
        }

        $torpedo->addTorpedoFusion($torpedoFusion);
        $em->persist($torpedo);
        $em->flush();

        return new JsonResponse([
            'message' => "Fusión en Torpedo realizada correctamente."
        ]);
    }

}
