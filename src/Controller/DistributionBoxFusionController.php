<?php

namespace App\Controller;

use App\Entity\DistributionBoxFusion;
use App\Form\DistributionBoxFusionType;
use App\Repository\DistributionBoxFusionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Doctrine\ORM\EntityManagerInterface;
use App\Entity\DistributionBox;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/distribution-box-fusion")
 */
class DistributionBoxFusionController extends AbstractController
{
    /**
     * @Route("/", name="distribution_box_fusion_index", methods={"GET"})
     */
    public function index(DistributionBoxFusionRepository $distributionBoxFusionRepository): Response
    {
        return $this->render('distribution_box_fusion/index.html.twig', [
            'distribution_box_fusions' => $distributionBoxFusionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="distribution_box_fusion_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $distributionBoxFusion = new DistributionBoxFusion();
        $form = $this->createForm(DistributionBoxFusionType::class, $distributionBoxFusion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($distributionBoxFusion);
            $entityManager->flush();

            return $this->redirectToRoute('distribution_box_fusion_index');
        }

        return $this->render('distribution_box_fusion/new.html.twig', [
            'distribution_box_fusion' => $distributionBoxFusion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="distribution_box_fusion_show", methods={"GET"})
     */
    public function show(DistributionBoxFusion $distributionBoxFusion): Response
    {
        return $this->render('distribution_box_fusion/show.html.twig', [
            'distribution_box_fusion' => $distributionBoxFusion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="distribution_box_fusion_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, DistributionBoxFusion $distributionBoxFusion): Response
    {
        $form = $this->createForm(DistributionBoxFusionType::class, $distributionBoxFusion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('distribution_box_fusion_index');
        }

        return $this->render('distribution_box_fusion/edit.html.twig', [
            'distribution_box_fusion' => $distributionBoxFusion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="distribution_box_fusion_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, DistributionBoxFusion $distributionBoxFusion): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            if (!$this->getUser()->isAdmin()) {
                return new JsonResponse([
                    'message' => "No tiene permisos para realizar esta acción."
                        ], Response::HTTP_FORBIDDEN);
            }
            $entityManager->remove($distributionBoxFusion);
            $entityManager->flush();
            return new JsonResponse([
                'message' => "Fusión eliminada correctamente."
            ]);
        }
        if ($this->isCsrfTokenValid('delete'.$distributionBoxFusion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($distributionBoxFusion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('distribution_box_fusion_index');
    }
    
    
    /**
     * @Route("/{id}", name="distribution_box_fusion_create", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function createFusion(
            Request $request,
            DistributionBox $distributionBox,
            EntityManagerInterface $em,
            ValidatorInterface $validator) {
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

        // TODO: Refactoring todo esto y pensar patrón
        $distributionBoxFusions = $em->getRepository(DistributionBoxFusion::class)->findAll();
        foreach ($distributionBoxFusions as $fusion) {
            foreach ($fusion->getFibers() as $fiber) {
                if (($fiber == $fiber1 || $fiber == $fiber2) && $distributionBox == $fusion->getDistributionBox()) {
                    return new JsonResponse([
                        'message' => "La fibra (" . $fiber . ") ya se encuentra fusionada en la caja de distribución (" . $fusion->getDistributionBox() . ")."
                            ], 400);
                }
            }
        }
        
        // Delete from pasants
        $distributionBoxPassants = $fiber1->getDistributionBoxPassants();
        foreach ($distributionBoxPassants as $distributionBoxPassant) {
            if ($distributionBoxPassant->getDistributionBox() === $distributionBox) {
                $em->remove($distributionBoxPassant);
            }
        }
        $distributionBoxPassants = $fiber2->getDistributionBoxPassants();
        foreach ($distributionBoxPassants as $distributionBoxPassant) {
            if ($distributionBoxPassant->getDistributionBox() === $distributionBox) {
                $em->remove($distributionBoxPassant);
            }
        }
        
        // Generate dsBox fusion
        $distributionBoxFusion = new DistributionBoxFusion();
        $distributionBoxFusion->addFiber($fiber1)->addFiber($fiber2);



        $distributionBoxErrors = $validator->validate($distributionBoxFusion);
        $fiber1Errors = $validator->validate($fiber1);
        $fiber2Errors = $validator->validate($fiber2);

        $errorsString = "";
        if (count($distributionBoxErrors) > 0) {
            $errorsString = (string) $distributionBoxErrors;
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

        $distributionBox->addDistributionBoxFusion($distributionBoxFusion);
        $em->persist($distributionBox);
        $em->flush();

        return new JsonResponse([
            'message' => "Fusión en Caja de distribución realizada correctamente."
        ]);
    }
}
