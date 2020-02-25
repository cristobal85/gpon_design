<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\WireRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\DistributionBoxPassant;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\DistributionBox;
use \Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DistributionBoxPassantController extends AbstractController {

    /**
     * @Route("/distribution-box-passant/{distributionBox}", name="distribution_box_passant_new", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(
            Request $request,
            WireRepository $wireRep,
            DistributionBox $distributionBox,
            EntityManagerInterface $em,
            ValidatorInterface $validator
    ) {
        $data = json_decode($request->getContent(), true)['data'];
        $wire1 = $wireRep->findOneBy(['id' => intval($data['wire1Id'])]);
        $wire2 = $wireRep->findOneBy(['id' => intval($data['wire2Id'])]);
        $passantsCount = 0;

        $wire1Tubes = $wire1->getTubes();
        for ($i = 0; $i < count($wire1Tubes); $i++) {
            $fibers = $wire1Tubes[$i]->getFibers();
            for ($j = 0; $j < count($fibers); $j++) {
                $fiber1 = $fibers[$j];
                $fiber2 = $wire2->getTubes()[$i]->getFibers()[$j];
                // TODO: Refactoring this
                if (!empty($fiber1) && !empty($fiber2) && $fiber1 !== $fiber2 &&
                        !$distributionBox->isFiberInUse($fiber1) && !$distributionBox->isFiberInUse($fiber2)) {
                    $distributionBoxPassant = new DistributionBoxPassant();
                    $distributionBoxPassant->addFiber($fiber1)->addFiber($fiber2)->setDistributionBox($distributionBox);
                    $distributionBox->addPassant($distributionBoxPassant);

                    $distributionBoxErrors = $validator->validate($distributionBoxPassant);
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

                    $em->persist($distributionBox);

                    $passantsCount++;
                }
            }
        }

        $em->flush();

        return new JsonResponse([
            'message' => 'Se han añadido (' . $passantsCount . ') pasantes en el torpedo.'
        ]);
    }

}
